<?php

namespace app\controllers;

use app\models\CentroCosto;
use app\models\CentroDistrito;
use app\models\Distrito;
use app\models\DistritoZona;
use app\models\Zona;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * DistritoController implements the CRUD actions for Distrito model.
 */
class DistritoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'Dependencias', 'DeleteDependencia', 'Create', 'Update', 'Delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'Dependencias', 'DeleteDependencia', 'Create', 'Update', 'Delete'],
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
     * Lists all Distrito models.
     * @return mixed
     */
    public function actionIndex()
    {
        $distritos = Distrito::find()->all();

        return $this->render('index', [
            'distritos' => $distritos,
        ]);
    }

    /**
     * Displays a single Distrito model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDependencias($id)
    {

        $array_post             = Yii::$app->request->post();
        $dependencias_asignadas = CentroDistrito::find()->where(['distrito_id' => $id])->all();
        $distrito               = $this->findModel($id);
        $asignaciones           = array_key_exists('dependencias', $array_post) ? $array_post['dependencias'] : array();

        $tamano_asignaciones = count($asignaciones);

        $index = 0;

        while ($index < $tamano_asignaciones) {

            $model = new CentroDistrito();
            $model->SetAttribute('centro_costo_codigo', $asignaciones[$index]);
            $model->SetAttribute('distrito_id', $id);
            $model->save();
            $index++;

        }

        if ($tamano_asignaciones > 0) {

            return $this->redirect('index');

        }

        $dependencias = CentroCosto::find()->orderBy(['nombre' => SORT_ASC])->all();

        return $this->render('dependencias', ['distrito' => $distrito, 'dependencias_asignadas' => $dependencias_asignadas, 'dependencias_data' => $dependencias]);

    }

    public function actionDeleteDependencia($id, $codigo)
    {
        $primaryConnection = Yii::$app->db;
        $primaryCommand    = $primaryConnection->createCommand("DELETE
                                                             FROM  centro_distrito
                                                             WHERE distrito_id = :distrito_id
                                                             AND   centro_costo_codigo = :dependencia
                                                             ");

        $borrado = $primaryCommand->bindValue(':distrito_id', $id)
            ->bindValue(':dependencia', $codigo)
            ->execute();

        return $this->redirect(Yii::$app->request->baseUrl . '/distrito/dependencias?id=' . $id);

    }

    /**
     * Creates a new Distrito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model      = new Distrito();
        $array_post = Yii::$app->request->post();
        $zonas      = Zona::find()->orderBy(['nombre' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $regional = array_key_exists('regional', $array_post) ? $array_post['regional'] : '';

            if ($regional != '') {

                $model_r = new DistritoZona();
                $model_r->setAttribute('distrito_id', $model->id);
                $model_r->setAttribute('zona_id', $regional);
                $model_r->save();

            }

            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
                'zonas' => $zonas,
            ]);
        }
    }

    /**
     * Updates an existing Distrito model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model      = $this->findModel($id);
        $array_post = Yii::$app->request->post();
        $zonas      = Zona::find()->orderBy(['nombre' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $regional = array_key_exists('regional', $array_post) ? $array_post['regional'] : '';

            if ($regional != '') {

                $primaryConnection = Yii::$app->db;
                $primaryCommand    = $primaryConnection->createCommand("DELETE
                                                                     FROM distrito_zona
                                                                    WHERE distrito_id = :distrito
                                                                   ");
                $primaryCommand->bindValue(':distrito', $model->id)->execute();

                $model_r = new DistritoZona();
                $model_r->setAttribute('distrito_id', $model->id);
                $model_r->setAttribute('zona_id', $regional);
                $model_r->save();

            }

            return $this->redirect('index');

        } else {
            return $this->render('update', [
                'model' => $model,
                'zonas' => $zonas,
            ]);
        }
    }

    /**
     * Deletes an existing Distrito model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Distrito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Distrito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Distrito::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
