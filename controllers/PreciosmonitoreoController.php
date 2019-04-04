<?php

namespace app\controllers;

use Yii;
use app\models\PreciosMonitoreo;
use app\models\PreciosMonitoreoSearch;
use app\models\Empresa;
use app\models\SistemaMonitoreado;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * PreciosmonitoreoController implements the CRUD actions for PreciosMonitoreo model.
 */
class PreciosmonitoreoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PreciosMonitoreo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PreciosMonitoreoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PreciosMonitoreo model.
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
     * Creates a new PreciosMonitoreo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PreciosMonitoreo();

        $consulta=$model->find()->all();

        $empresas=Empresa::find()->all();
        $list_empresas=ArrayHelper::map($empresas,'nit','nombre');

        $sistema_mon=SistemaMonitoreado::find()->all();
        $list_sistema_mon=ArrayHelper::map($sistema_mon,'id','nombre');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success','Creado correctamente');
            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'empresas'=>$list_empresas,
                'sistema_monitoreado'=>$list_sistema_mon,
                'consulta'=>$consulta
            ]);
        }
    }

    /**
     * Updates an existing PreciosMonitoreo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $empresas=Empresa::find()->all();
        $list_empresas=ArrayHelper::map($empresas,'nit','nombre');

        $sistema_mon=SistemaMonitoreado::find()->all();
        $list_sistema_mon=ArrayHelper::map($sistema_mon,'id','nombre');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->session->setFlash('success','Actualizado correctamente');
            return $this->redirect(['create']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'empresas'=>$list_empresas,
                'sistema_monitoreado'=>$list_sistema_mon,
            ]);
        }
    }

    /**
     * Deletes an existing PreciosMonitoreo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success','Eliminado correctamente');

        return $this->redirect(['create']);
    }

    /**
     * Finds the PreciosMonitoreo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PreciosMonitoreo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PreciosMonitoreo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
