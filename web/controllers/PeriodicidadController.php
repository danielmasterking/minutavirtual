<?php

namespace app\controllers;

use Yii;
use app\models\Periodicidad;
use app\models\PeriodicidadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PeriodicidadController implements the CRUD actions for Periodicidad model.
 */
class PeriodicidadController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'Create', 'Update', 'Delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'Create', 'Update', 'Delete'],
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
     * Lists all Periodicidad models.
     * @return mixed
     */
    public function actionIndex()
    {
		$periodicidades = Periodicidad::find()->orderBy(['nombre' => SORT_ASC])->all();
        
        return $this->render('index', [
            'periodicidades' =>$periodicidades,
            'periodicidad' => 'active',
        ]);
    }

    /**
     * Displays a single Periodicidad model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
			'periodicidad' => 'active',
        ]);
    }

    /**
     * Creates a new Periodicidad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Periodicidad();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
				'periodicidad' => 'active',
            ]);
        }
    }

    /**
     * Updates an existing Periodicidad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
				'periodicidad' => 'active',
            ]);
        }
    }

    /**
     * Deletes an existing Periodicidad model.
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
     * Finds the Periodicidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Periodicidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Periodicidad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
