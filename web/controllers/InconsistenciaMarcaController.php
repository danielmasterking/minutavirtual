<?php

namespace app\controllers;

use Yii;
use app\models\InconsistenciaMarca;
use app\models\MaestraProveedor;
use app\models\Marca;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * InconsistenciaMarcaController implements the CRUD actions for InconsistenciaMarca model.
 */
class InconsistenciaMarcaController extends Controller
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
     * Lists all InconsistenciaMarca models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => InconsistenciaMarca::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InconsistenciaMarca model.
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
     * Creates a new InconsistenciaMarca model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InconsistenciaMarca();
		$inconsistencias = InconsistenciaMarca::find()->all();
        $maestras = MaestraProveedor::find()->all();
		$marcas = Marca::find()->orderBy(['nombre' => SORT_ASC])->all();
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('create');
        } else {
            return $this->render('create', [
                'model' => $model,
				'inconsistencias' => $inconsistencias,
			    'inconsistencia' => 'active',
				'maestras' => $maestras,
				'marcas' => $marcas,
            ]);
        }
    }

    /**
     * Updates an existing InconsistenciaMarca model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$inconsistencias = InconsistenciaMarca::find()->all();
        $maestras = MaestraProveedor::find()->all();
		$marcas = Marca::find()->orderBy(['nombre' => SORT_ASC])->all();		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('create');
        } else {
            return $this->render('update', [
                'model' => $model,
				'inconsistencias' => $inconsistencias,
			    'inconsistencia' => 'active',
				'maestras' => $maestras,
				'marcas' => $marcas,				
            ]);
        }
    }

    /**
     * Deletes an existing InconsistenciaMarca model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect('create');
    }

    /**
     * Finds the InconsistenciaMarca model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InconsistenciaMarca the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InconsistenciaMarca::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
