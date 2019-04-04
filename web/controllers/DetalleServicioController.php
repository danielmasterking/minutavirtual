<?php

namespace app\controllers;

use Yii;
use app\models\DetalleServicio;
use app\models\Servicio;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DetalleServicioController implements the CRUD actions for DetalleServicio model.
 */
class DetalleServicioController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'Create', 'Update', 'delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'Create', 'Update', 'delete'],
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
     * Lists all DetalleServicio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => DetalleServicio::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DetalleServicio model.
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
     * Creates a new DetalleServicio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DetalleServicio();
		$servicios = Servicio::find()->orderBy(['nombre' => SORT_ASC])->all();
        $codigos = DetalleServicio::find()->orderBy(['codigo' => SORT_ASC])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('create');
        } else {
            return $this->render('create', [
                'model' => $model,
				'servicios' => $servicios,
				'codigos' => $codigos,
				'codigo' => 'active',
            ]);
        }
    }

    /**
     * Updates an existing DetalleServicio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $codigos = DetalleServicio::find()->orderBy(['codigo' => SORT_ASC])->all();
        $servicios = Servicio::find()->orderBy(['nombre' => SORT_ASC])->all();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('create');
        } else {
            return $this->render('update', [
                'model' => $model,
				'codigos' => $codigos,
				'servicios' => $servicios,
				'codigo' => 'active',				
            ]);
        }
    }

    /**
     * Deletes an existing DetalleServicio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['create']);
    }

    /**
     * Finds the DetalleServicio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DetalleServicio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DetalleServicio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
