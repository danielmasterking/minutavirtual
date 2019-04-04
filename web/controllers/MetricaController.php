<?php

namespace app\controllers;

use Yii;
use app\models\Metrica;
use app\models\Indicador;
use app\models\Periodicidad;
use app\models\MetricaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MetricaController implements the CRUD actions for Metrica model.
 */
class MetricaController extends Controller
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
     * Lists all Metrica models.
     * @return mixed
     */
    public function actionIndex()
    {
        $metricas = Metrica::find()->orderBy(['nombre' => SORT_ASC])->all();

        return $this->render('index', [
            'metricas' => $metricas,
            'metrica' => 'active',
        ]);
    }

    /**
     * Displays a single Metrica model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
			'metrica' => 'active',
        ]);
    }

    /**
     * Creates a new Metrica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Metrica();
        $periodicidades = Periodicidad::find()->orderBy(['nombre' => SORT_ASC])->all();
		$indicadores = Indicador::find()->orderBy(['nombre' => SORT_ASC])->all();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
				'indicadores' => $indicadores,
				'periodicidades' => $periodicidades,
				'metrica' => 'active',
            ]);
        }
    }

    /**
     * Updates an existing Metrica model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	    $periodicidades = Periodicidad::find()->orderBy(['nombre' => SORT_ASC])->all();
		$indicadores = Indicador::find()->orderBy(['nombre' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
				'indicadores' => $indicadores,
				'periodicidades' => $periodicidades,
				'metrica' => 'active',
            ]);
        }
    }

    /**
     * Deletes an existing Metrica model.
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
     * Finds the Metrica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Metrica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Metrica::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
