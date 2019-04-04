<?php

namespace app\controllers;

use app\models\CategoriaVisita;
use app\models\CentroCosto;
use app\models\DetalleVisitaDia;
use app\models\DetalleVisitaSeccion;
use app\models\Seccion;
use app\models\Usuario;
use app\models\ValorNovedad;
use app\models\VisitaDia;
use kartik\mpdf\Pdf;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
/**
 * VisitaDiaController implements the CRUD actions for VisitaDia model.
 */
class VisitaDiaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        	'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'ViewFromCordinador', 'Pdf', 'Create', 'Update', 'Delete', 'DeleteFromCordinador'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'ViewFromCordinador', 'Pdf', 'Create', 'Update', 'Delete', 'DeleteFromCordinador'],
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
     * Lists all VisitaDia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => VisitaDia::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VisitaDia model.
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

        $model = $this->findModel($id);

        $pdf = Yii::$app->pdf;

        $pdf->filename = 'Visita_Quincenal_' . $model->fecha . '_' . $model->dependencia->nombre . '.pdf';

        $pdf->content = $this->renderPartial('_pdf', ['model' => $model], true);

        $pdf->destination = Pdf::DEST_DOWNLOAD;

        return $pdf->render();

        //return $this->redirect('view', ['id' => $id,]);

    }

    /**
     * Creates a new VisitaDia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model                          = new VisitaDia();
        $array_post                     = Yii::$app->request->post();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath                      = '/uploads/';
        Yii::$app->session->setTimeout(5400);
        $categorias       = CategoriaVisita::find()->orderBy(['id' => SORT_ASC])->all();
        $dependencias     = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
        $secciones        = Seccion::find()->orderBy(['id' => SORT_ASC])->all();
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

            $image = UploadedFile::getInstance($model, 'image');

            if ($image !== null) {
                $model->foto = $image->name;
                $ext         = end((explode(".", $image->name)));
                $name        = date('Ymd') . rand(1, 10000) . '' . $model->foto;
                $path        = Yii::$app->params['uploadPath'] . $name;
                $model->foto = $shortPath . $name;
                $model->save();
                $image->saveAs($path);

            }

            //Guardar Modelo relacionado

            /*obtener cantidad de novedades
             *
             * Tener en cuenta que cuando indice sea = 10 hay que almacenar sección
             *
             */

            $tamanoNovedades = array_key_exists('cantidad', $array_post) ? $array_post['cantidad'] : 0;

            for ($i = 1; $i <= $tamanoNovedades; $i++) {

                if ($i != 10) {

                    $obs          = array_key_exists('text-novedad-' . $i, $array_post) ? $array_post['text-novedad-' . $i] : '';
                    $mensaje      = array_key_exists('mensaje-novedad-' . $i, $array_post) ? $array_post['mensaje-novedad-' . $i] : '';
                    $valorNovedad = array_key_exists('valor-novedad-' . $i, $array_post) ? $array_post['valor-novedad-' . $i] : '';

                    $valorNovedadModel = ValorNovedad::findOne($valorNovedad);

                    if ($valorNovedadModel != null) {

                        $modelDetalle = new DetalleVisitaDia();
                        $modelDetalle->setAttribute('visita_dia_id', $model->id);
                        $modelDetalle->setAttribute('observacion', $obs);
                        $modelDetalle->setAttribute('novedad_categoria_visita_id', $i);
                        $modelDetalle->setAttribute('mensaje_novedad_id', $mensaje);
                        $modelDetalle->setAttribute('resultado_id', $valorNovedadModel->resultado_id);
                        $modelDetalle->save();

                    }

                } else {

                    $obsA               = array_key_exists('txt-seccion-a', $array_post) ? $array_post['txt-seccion-a'] : '';
                    $obsB               = array_key_exists('txt-seccion-b', $array_post) ? $array_post['txt-seccion-a'] : '';
                    $obsC               = array_key_exists('txt-seccion-c', $array_post) ? $array_post['txt-seccion-a'] : '';
                    $mensajeA           = array_key_exists('mensaje-seccion-a', $array_post) ? $array_post['mensaje-seccion-a'] : '';
                    $mensajeB           = array_key_exists('mensaje-seccion-b', $array_post) ? $array_post['mensaje-seccion-b'] : '';
                    $mensajeC           = array_key_exists('mensaje-seccion-c', $array_post) ? $array_post['mensaje-seccion-c'] : '';
                    $valorNovedadA      = array_key_exists('valor-seccion-a', $array_post) ? $array_post['valor-seccion-a'] : '';
                    $valorNovedadB      = array_key_exists('valor-seccion-b', $array_post) ? $array_post['valor-seccion-b'] : '';
                    $valorNovedadC      = array_key_exists('valor-seccion-c', $array_post) ? $array_post['valor-seccion-c'] : '';
                    $seccionA           = array_key_exists('seccion-a', $array_post) ? $array_post['seccion-a'] : '';
                    $seccionB           = array_key_exists('seccion-b', $array_post) ? $array_post['seccion-b'] : '';
                    $seccionC           = array_key_exists('seccion-c', $array_post) ? $array_post['seccion-c'] : '';
                    $valorNovedadModelA = ValorNovedad::findOne($valorNovedadA);
                    $valorNovedadModelB = ValorNovedad::findOne($valorNovedadB);
                    $valorNovedadModelC = ValorNovedad::findOne($valorNovedadC);

                    if ($valorNovedadModelA != null && $seccionA != '') {

                        $modelDetalle = new DetalleVisitaDia();
                        $modelDetalle->setAttribute('visita_dia_id', $model->id);
                        $modelDetalle->setAttribute('observacion', $obsA);
                        $modelDetalle->setAttribute('novedad_categoria_visita_id', $i);
                        $modelDetalle->setAttribute('mensaje_novedad_id', $mensajeA);
                        $modelDetalle->setAttribute('resultado_id', $valorNovedadModelA->resultado_id);
                        $modelDetalle->save();
                        $detalleSeccion = new DetalleVisitaSeccion();
                        $detalleSeccion->setAttribute('detalle_visita_dia_id', $modelDetalle->id);
                        $detalleSeccion->setAttribute('seccion_id', $seccionA);
                        $detalleSeccion->save();
                    }

                    if ($valorNovedadModelB != null && $seccionB != '') {

                        $modelDetalle = new DetalleVisitaDia();
                        $modelDetalle->setAttribute('visita_dia_id', $model->id);
                        $modelDetalle->setAttribute('observacion', $obsB);
                        $modelDetalle->setAttribute('novedad_categoria_visita_id', $i);
                        $modelDetalle->setAttribute('mensaje_novedad_id', $mensajeB);
                        $modelDetalle->setAttribute('resultado_id', $valorNovedadModelB->resultado_id);
                        $modelDetalle->save();
                        $detalleSeccion = new DetalleVisitaSeccion();
                        $detalleSeccion->setAttribute('detalle_visita_dia_id', $modelDetalle->id);
                        $detalleSeccion->setAttribute('seccion_id', $seccionB);
                        $detalleSeccion->save();
                    }

                    if ($valorNovedadModelC != null && $seccionC != '') {

                        $modelDetalle = new DetalleVisitaDia();
                        $modelDetalle->setAttribute('visita_dia_id', $model->id);
                        $modelDetalle->setAttribute('observacion', $obsC);
                        $modelDetalle->setAttribute('novedad_categoria_visita_id', $i);
                        $modelDetalle->setAttribute('mensaje_novedad_id', $mensajeC);
                        $modelDetalle->setAttribute('resultado_id', $valorNovedadModelC->resultado_id);
                        $modelDetalle->save();
                        $detalleSeccion = new DetalleVisitaSeccion();
                        $detalleSeccion->setAttribute('detalle_visita_dia_id', $modelDetalle->id);
                        $detalleSeccion->setAttribute('seccion_id', $seccionC);
                        $detalleSeccion->save();
                    }

                }

            }
            $model = new VisitaDia();
            return $this->render('create', [
                'model'            => $model,
                //'modelDetalle' => $modelDetalle,
                'categorias'       => $categorias,
                'dependencias'     => $dependencias,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'periodica'        => 'active',
                'zonasUsuario'     => $zonasUsuario,
                'secciones'        => $secciones,
                'done'             => '200',
            ]);

        } else {
            return $this->render('create', [
                'model'            => $model,
                //'modelDetalle' => $modelDetalle,
                'categorias'       => $categorias,
                'dependencias'     => $dependencias,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'periodica'        => 'active',
                'zonasUsuario'     => $zonasUsuario,
                'secciones'        => $secciones,
            ]);
        }
    }

    /**
     * Updates an existing VisitaDia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        Yii::$app->session->setTimeout(5400);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VisitaDia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $dependencia)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['centro-costo/visita?id=' . $dependencia]);
    }

    public function actionDeleteFromCordinador($id, $usuario)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['usuario/visita?id=' . $usuario]);
    }

    /**
     * Finds the VisitaDia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VisitaDia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VisitaDia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
