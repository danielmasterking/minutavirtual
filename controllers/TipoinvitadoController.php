<?php

namespace app\controllers;

use Yii;
use app\models\TipoInvitado;
use app\models\TipoInvitadoSearch;
use app\models\Empresa;
use app\models\Usuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * TipoinvitadoController implements the CRUD actions for TipoInvitado model.
 */
class TipoinvitadoController extends Controller
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
                'only'  => ['index', 'create','update','delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'create','update','delete'],
                        'roles'   => ['@'], //para usuarios logueados
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TipoInvitado models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $empresas = array();
        if($usuario != null){
         
          $empresasUsuario = $usuario->empresas;
          $emp='';
          foreach ($empresasUsuario as $value) {
            $emp=$value->nit;
            
            //echo $emp;
          }
        }


        

        $searchModel = new TipoInvitado();

        $roles = Yii::$app->session['rol-exito'];

        if (in_array("administrador", $roles)) {
            $query= $searchModel->find();
        }else{
            $query= $searchModel->find()->where('nit_empresa="'.$emp.'"');
        }

        $dataProvider =new ActiveDataProvider([
            'query' => $query
        ]);



        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoInvitado model.
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
     * Creates a new TipoInvitado model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TipoInvitado();

        $empresas=Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();

        $list_empresas=ArrayHelper::map($empresas,'nit','nombre');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index'/*, 'id' => $model->id*/]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'list_empresas'=>$list_empresas
            ]);
        }
    }

    /**
     * Updates an existing TipoInvitado model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

         $empresas=Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();

        $list_empresas=ArrayHelper::map($empresas,'nit','nombre');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index'/*, 'id' => $model->id*/]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'list_empresas'=>$list_empresas
            ]);
        }
    }

    /**
     * Deletes an existing TipoInvitado model.
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
     * Finds the TipoInvitado model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TipoInvitado the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipoInvitado::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
