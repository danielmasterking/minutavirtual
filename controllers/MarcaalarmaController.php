<?php

namespace app\controllers;

use Yii;
use app\models\MarcaAlarma;
use app\models\MarcaAlarmaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarcaalarmaController implements the CRUD actions for MarcaAlarma model.
 */
class MarcaalarmaController extends Controller
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
     * Lists all MarcaAlarma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarcaAlarmaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MarcaAlarma model.
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
     * Creates a new MarcaAlarma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MarcaAlarma();

        $marca_alarmas=$model->find()->orderBy(['nombre' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success','Creado correctamente');
            return $this->redirect(['create']);

        } else {
            return $this->render('create', [
                'model' => $model,
                'marca_alarma' => 'active',
                'marca_alarmas'=>$marca_alarmas
            ]);
        }
    }

    /**
     * Updates an existing MarcaAlarma model.
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
                'marca_alarma' => 'active',
            ]);
        }
    }

    /**
     * Deletes an existing MarcaAlarma model.
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
     * Finds the MarcaAlarma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MarcaAlarma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MarcaAlarma::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
