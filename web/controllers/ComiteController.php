<?php

namespace app\controllers;

use app\models\CentroCosto;
use app\models\Comite;
use app\models\ComiteCordinador;
use app\models\ComiteDependencia;
use app\models\ComiteDistrito;
use app\models\Distrito;
use app\models\Marca;
use app\models\Novedad;
use app\models\Usuario;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * ComiteController implements the CRUD actions for Comite model.
 */
class ComiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'ViewPersonales', 'ViewFromCordinador', 'Create', 'Update',
                    		'Pdf', 'Marcas', 'Cordinadores', 'Personales', 'delete', 'DeleteFromCordinador'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'ViewPersonales', 'ViewFromCordinador', 'Create', 'Update',
                    				  'Pdf', 'Marcas', 'Cordinadores', 'Personales', 'delete', 'DeleteFromCordinador'],
                        'roles'   => ['@'], //para usuarios logueados
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Comite models.
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index', [
            'dataProvider' => null,
        ]);
    }

    /**
     * Displays a single Comite model.
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

    public function actionViewPersonales($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            //'dependencia' => $dependencia,
        ]);
    }

    public function actionViewFromCordinador($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),

        ]);
    }

    /**
     * Creates a new Comite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->session->setTimeout(5400);
        $model                          = new Comite();
        $array_post                     = Yii::$app->request->post();
        $novedades                      = Novedad::find()->where(['tipo' => 'D'])->orderBy(['nombre' => SORT_ASC])->all();
        $marcas                         = Marca::find()->orderBy(['nombre' => SORT_ASC])->all();
        $distritos                      = Distrito::find()->orderBy(['nombre' => SORT_ASC])->all();
        $dependencias                   = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
        $usuario                        = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $cordinadores                   = Usuario::find()->orderBy(['nombres' => SORT_ASC])->all();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath                      = '/uploads/';

        $marca            = array_key_exists('marca-cod', $array_post) ? $array_post['marca-cod'] : '';
        $dependencia      = array_key_exists('dependencia-cod', $array_post) ? $array_post['dependencia-cod'] : '';
        $zonasUsuario     = array();
        $marcasUsuario    = array();
        $distritosUsuario = array();

        if ($usuario != null) {

            $zonasUsuario     = $usuario->zonas;
            $marcasUsuario    = $usuario->marcas;
            $distritosUsuario = $usuario->distritos;

        }

        if ($model->load(Yii::$app->request->post())) {

            $image = UploadedFile::getInstance($model, 'image');
            $file  = UploadedFile::getInstance($model, 'file');

            if ($image !== null) {
                $model->foto = $image->name;
                $ext         = end((explode(".", $image->name)));
                $name        = date('Ymd') . rand(1, 10000) . '' . $model->foto;
                $path        = Yii::$app->params['uploadPath'] . $name;
                $model->foto = $shortPath . $name;
                $image->saveAs($path);

            }
            echo $path;exit();
            if ($file !== null) {
                $model->lista = $file->name;
                $ext          = end((explode(".", $file->name)));
                $name         = date('Ymd') . rand(1, 10000) . '' . $model->lista;
                $path         = Yii::$app->params['uploadPath'] . $name;
                $model->lista = $shortPath . $name;
                try {
                    
                    $file->saveAs($path);
                } catch (\Exception $e) {
                    echo ''.$e;exit();
                }
            }else{
                echo $file;exit();
            }
            //$model->save();
            /*************Guardar Modelos relacionados***************************/

            if ($marca != '') {

                // $comite_marca_model = new ComiteMarca();
                $comite_marca_model = new ComiteDistrito();
                $comite_marca_model->setAttribute('comite_id', $model->id);
                //$comite_marca_model->setAttribute('marca_id',$marca);
                $comite_marca_model->setAttribute('distrito_id', $marca);
                $comite_marca_model->save();

            }

            if ($dependencia != '') {

                $comite_dependencia_model = new ComiteDependencia();
                $comite_dependencia_model->setAttribute('comite_id', $model->id);
                $comite_dependencia_model->setAttribute('centro_costo_codigo', $dependencia);
                $comite_dependencia_model->save();
            }

            $cantidad = array_key_exists('cantidad-cor', $array_post) ? $array_post['cantidad-cor'] : 0;

            if ($cantidad > 0) {

                //guardar capacitacion dependencia
                for ($i = 1; $i <= $cantidad; $i++) {

                    $cordinador = array_key_exists('sel-cor-' . $i, $array_post) ? $array_post['sel-cor-' . $i] : '';

                    if ($cordinador != '') {
                        //VarDumper::dump($cordinador);
                        $comite_cordinador = new ComiteCordinador();
                        $comite_cordinador->setAttribute('usuario', $cordinador);
                        $comite_cordinador->setAttribute('comite_id', $model->id);
                        $comite_cordinador->save();

                        /**************************************************************/

                        /***************************************************************/

                    }

                }

            }

            /********************************************************************/

            $model = new Comite();
            return $this->render('create', [
                'model'            => $model,
                'novedades'        => $novedades,
                'marcas'           => $marcas,
                'distritos'        => $distritos,
                'dependencias'     => $dependencias,
                'cordinadores'     => $cordinadores,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'zonasUsuario'     => $zonasUsuario,
                'nuevo'            => 'active',
                'done'             => '200',
            ]);

        } else {
            return $this->render('create', [
                'model'            => $model,
                'novedades'        => $novedades,
                'marcas'           => $marcas,
                'distritos'        => $distritos,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'zonasUsuario'     => $zonasUsuario,
                'cordinadores'     => $cordinadores,
                'dependencias'     => $dependencias,
                'nuevo'            => 'active',
            ]);
        }
    }

    /**
     * Updates an existing Comite model.
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

    public function actionPdf($id)
    {

        $model = $this->findModel($id);

        $pdf = Yii::$app->pdf;

        $pdf->filename = 'Comite_' . $model->fecha . '_' . $model->novedad->nombre . '.pdf';

        $pdf->content = $this->renderPartial('_pdf', ['model' => $model], true);

        $pdf->destination = Pdf::DEST_DOWNLOAD;

        return $pdf->render();

        //return $this->redirect('view', ['id' => $id,]);

    }

    public function actionMarcas()
    {

        //$comites = ComiteMarca::find()->orderBy(['comite_id' => SORT_DESC])->all();
        $comites = ComiteDistrito::find()->orderBy(['comite_id' => SORT_DESC])->all();
        return $this->render('marcas', [
            'comites' => $comites,
            'marcas'  => 'active',
        ]);
    }

    public function actionCordinadores()
    {

        $comites = ComiteCordinador::find()->orderBy(['comite_id' => SORT_DESC])->all();

        return $this->render('cordinadores', [
            'comites'      => $comites,
            'cordinadores' => 'active',
        ]);
    }

    public function actionPersonales()
    {

        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $comites = Comite::find()->where(['usuario' => $usuario])->orderBy(['id' => SORT_DESC])->all();

        return $this->render('personales', [
            'comites'    => $comites,
            'personales' => 'active',
        ]);
    }

    /**
     * Deletes an existing Comite model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $dependencia)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['centro-costo/comite?id=' . $dependencia]);
    }

    public function actionDeleteFromCordinador($id, $usuario)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['usuario/comite?id=' . $usuario]);
    }

    /**
     * Finds the Comite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comite::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
