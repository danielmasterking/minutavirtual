<?php

namespace app\controllers;

use Yii;
use app\models\PuestosDependencia;
use app\models\PuestosDependenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\CentroCosto;
use app\models\Empresa;
use app\models\Zona;
use app\models\Usuario;

/**
 * PuestosdependenciaController implements the CRUD actions for PuestosDependencia model.
 */
class PuestosdependenciaController extends Controller
{
    /**
     * @inheritdoc
     */

    public $layout="admin/main";


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index','create','delete','update'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index','create','delete','update'],
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
     * Lists all PuestosDependencia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PuestosDependenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PuestosDependencia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PuestosDependencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PuestosDependencia();


        $dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();    
        $empresas = Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();
        $zonas = Zona::find()->all();
        Yii::$app->session->setTimeout(5400);               
        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $zonasUsuario = array();
        //$marcasUsuario = array();
        $distritosUsuario = array();
        $empresasUsuario = array();
    
        $filas = array();
        
        if($usuario != null){
          $zonasUsuario = $usuario->zonas;      
         // $marcasUsuario = $usuario->marcas;
          $distritosUsuario = $usuario->distritos;        
          $empresasUsuario = $usuario->empresas;

        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                 'zonas' => $zonas,
                'dependencias' => $dependencias,
                'empresas' => $empresas,
                'zonasUsuario' => $zonasUsuario,
                //'marcasUsuario' => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,                
                'empresasUsuario' => $empresasUsuario
            ]);
        }
    }

    /**
     * Updates an existing PuestosDependencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();    
        $empresas = Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();
        $zonas = Zona::find()->all();
        Yii::$app->session->setTimeout(5400);               
        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $zonasUsuario = array();
        //$marcasUsuario = array();
        $distritosUsuario = array();
        $empresasUsuario = array();
    
        $filas = array();
        
        if($usuario != null){
          $zonasUsuario = $usuario->zonas;      
         // $marcasUsuario = $usuario->marcas;
          $distritosUsuario = $usuario->distritos;        
          $empresasUsuario = $usuario->empresas;

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                 'zonas' => $zonas,
                'dependencias' => $dependencias,
                'empresas' => $empresas,
                'zonasUsuario' => $zonasUsuario,
                //'marcasUsuario' => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,                
                'empresasUsuario' => $empresasUsuario
            ]);
        }
    }

    /**
     * Deletes an existing PuestosDependencia model.
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
     * Finds the PuestosDependencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PuestosDependencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PuestosDependencia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
