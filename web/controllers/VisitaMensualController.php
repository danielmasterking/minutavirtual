<?php

namespace app\controllers;

use app\models\ArchivoVisitaMensual;
use app\models\CentroCosto;
use app\models\Usuario;
use app\models\VisitaMensual;
use kartik\mpdf\Pdf;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
/**
 * VisitaMensualController implements the CRUD actions for VisitaMensual model.
 */
class VisitaMensualController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'ViewFromCordinador', 'Create', 'Update', 'Delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'ViewFromCordinador', 'Create', 'Update', 'Delete'],
                        'roles'   => ['@'], //para usuarios logueados
                    ],
                ],  
            ],
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all VisitaMensual models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => VisitaMensual::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VisitaMensual model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $dependencia)
    {
        return $this->render('view', [
            'model'       => $this->findModel($id),
            'dependencia' => $dependencia,
        ]);
    }

    public function actionViewFromCordinador($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),

        ]);
    }

    public function actionPdf($id)
    {

        $model     = $this->findModel($id);
        $modelFoto = ArchivoVisitaMensual::find()->where(['visita_mensual_id' => $id])->all();

        $pdf = Yii::$app->pdf;

        $pdf->filename = 'Visita_Semestral_' . $model->fecha_visita . '_' . $model->dependencia->nombre . '.pdf';

        $pdf->content = $this->renderPartial('_pdf', ['model' => $model, 'model_foto' => $modelFoto], true);

        $pdf->destination = Pdf::DEST_DOWNLOAD;

        return $pdf->render();

        //return $this->redirect('view', ['id' => $id,]);

    }

    /**
     * Creates a new VisitaMensual model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model                          = new VisitaMensual();
        $array_post                     = Yii::$app->request->post();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath                      = '/uploads/';
        Yii::$app->session->setTimeout(5400);
        $dependencias     = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
        $usuario          = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $zonasUsuario     = array();
        $marcasUsuario    = array();
        $distritosUsuario = array();

        if ($usuario != null) {

            $zonasUsuario     = $usuario->zonas;
            $marcasUsuario    = $usuario->marcas;
            $distritosUsuario = $usuario->distritos;

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $fecha_real_visita = strtotime('+1 day', strtotime($model->fecha_visita));
            $fecha_real_visita = date('Y-m-d', $fecha_real_visita);
            $model->setAttribute('fecha_visita', $fecha_real_visita);
            $model->save();

            $files = UploadedFile::getInstances($model, 'file');

            foreach ($files as $file) {

                if ($file !== null) {
                    $archivo = new ArchivoVisitaMensual();
                    $ext     = end((explode(".", $file->name)));
                    $name    = date('Ymd') . rand(1, 10000) . '' . $file->name;
                    $path    = Yii::$app->params['uploadPath'] . $name;
                    $archivo->setAttribute('archivo', $shortPath . $name);
                    $archivo->setAttribute('visita_mensual_id', $model->id);
                    $file->saveAs($path);
                    $archivo->save();

                }

            }

            $model = new VisitaMensual();
            return $this->render('create', [
                'model'            => $model,
                'dependencias'     => $dependencias,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'zonasUsuario'     => $zonasUsuario,
                'mensual'          => 'active',
                'done'             => '200',
            ]);

        } else {
            return $this->render('create', [
                'model'            => $model,
                'dependencias'     => $dependencias,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'mensual'          => 'active',
                'zonasUsuario'     => $zonasUsuario,
                //'zonas' => $zonas,
            ]);
        }
    }

    /**
     * Updates an existing VisitaMensual model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VisitaMensual model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDeleteFromCordinador($id, $usuario)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['usuario/mensual?id=' . $usuario]);
    }

    /**
     * Finds the VisitaMensual model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VisitaMensual the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VisitaMensual::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
