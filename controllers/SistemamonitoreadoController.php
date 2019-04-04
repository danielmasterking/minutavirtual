<?php

namespace app\controllers;

use Yii;
use app\models\SistemaMonitoreado;
use app\models\SistemaMonitoreadoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SistemamonitoreadoController implements the CRUD actions for SistemaMonitoreado model.
 */
class SistemamonitoreadoController extends Controller
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
     * Lists all SistemaMonitoreado models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SistemaMonitoreadoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SistemaMonitoreado model.
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
     * Creates a new SistemaMonitoreado model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SistemaMonitoreado();

        $consulta=$model->find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success','Creado correctamente');
            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'consulta'=>$consulta
            ]);
        }
    }

    /**
     * Updates an existing SistemaMonitoreado model.
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
            ]);
        }
    }

    /**
     * Deletes an existing SistemaMonitoreado model.
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
     * Finds the SistemaMonitoreado model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SistemaMonitoreado the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SistemaMonitoreado::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
