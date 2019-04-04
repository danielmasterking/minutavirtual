<?php

namespace app\controllers;

use Yii;
use app\models\DescAlarma;
use app\models\DescAlarmaSearch;
use app\models\TipoAlarma;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * DescAlarmaController implements the CRUD actions for DescAlarma model.
 */
class DescalarmaController extends Controller
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
     * Lists all DescAlarma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DescAlarmaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DescAlarma model.
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
     * Creates a new DescAlarma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DescAlarma();

        $array_post = Yii::$app->request->post();

        $alarmas = TipoAlarma::find()->orderBy(['nombre' => SORT_ASC])->all();

        $list_alarmas=ArrayHelper::map($alarmas,'id','nombre');

        $desc_alarmas_all=DescAlarma::find()->all();




        if ($model->load(Yii::$app->request->post()) ) {

            //$contar=DescAlarma::find()->where('id_tipo_alarma='.$array_post['DescAlarma']['id_tipo_alarma'])->count();

            //if ($contar>0) {
              //  Yii::$app->session->setFlash('danger','Ya se le agrego una descripcion a este tipo de alarma');
               
            //}else{
                $model->save();
                Yii::$app->session->setFlash('success','Creado correctamente');
            //}

            
            return $this->redirect(['create']);

        } else {
            return $this->render('create', [
                'model' => $model,
                'desc_alarma' => 'active',
                'alarmas'=>$list_alarmas,
                'desc_alarmas_all'=>$desc_alarmas_all
            ]);
        }
    }

    /**
     * Updates an existing DescAlarma model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $array_post = Yii::$app->request->post();

        $alarmas = TipoAlarma::find()->orderBy(['nombre' => SORT_ASC])->all();
        $list_alarmas=ArrayHelper::map($alarmas,'id','nombre');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

           // $contar=DescAlarma::find()->where('id_tipo_alarma='.$array_post['DescAlarma']['id_tipo_alarma'])->count();


            //if ($contar>0) {
              //  Yii::$app->session->setFlash('danger','Ya se le agrego una descripcion a este tipo de alarma');
               
            //}else{
                $model->save();
                Yii::$app->session->setFlash('success','Actualizado correctamente');
            //}

            
            return $this->redirect(['create']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'alarmas'=>$list_alarmas,
                'desc_alarma' => 'active',
            ]);
        }
    }

    /**
     * Deletes an existing DescAlarma model.
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
     * Finds the DescAlarma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DescAlarma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DescAlarma::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
