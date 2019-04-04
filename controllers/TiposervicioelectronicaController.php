<?php

namespace app\controllers;

use Yii;
use app\models\TipoServicioElectronica;
use app\models\TipoServicioElectronicaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TiposervicioelectronicaController implements the CRUD actions for TipoServicioElectronica model.
 */
class TiposervicioelectronicaController extends Controller
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
     * Lists all TipoServicioElectronica models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TipoServicioElectronicaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoServicioElectronica model.
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
     * Creates a new TipoServicioElectronica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TipoServicioElectronica();

        $servicios=TipoServicioElectronica::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success','Creado correctamente');
            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'tipo_serv_elect' => 'active',
                'servicios'=>$servicios
            ]);
        }
    }

    /**
     * Updates an existing TipoServicioElectronica model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success','Actualizado correctamente');
            return $this->redirect(['create']);
        } else {
            return $this->render('update', [
                'model' => $model,
                 'tipo_serv_elect' => 'active',
            ]);
        }
    }

    /**
     * Deletes an existing TipoServicioElectronica model.
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
     * Finds the TipoServicioElectronica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TipoServicioElectronica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipoServicioElectronica::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
