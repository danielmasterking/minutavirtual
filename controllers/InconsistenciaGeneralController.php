<?php

namespace app\controllers;

use Yii;
use app\models\InconsistenciaGeneral;
use app\models\MaestraProveedor;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * InconsistenciaGeneralController implements the CRUD actions for InconsistenciaGeneral model.
 */
class InconsistenciaGeneralController extends Controller
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
     * Lists all InconsistenciaGeneral models.
     * @return mixed
     */
    public function actionIndex()
    {
        $inconsistencias = InconsistenciaGeneral::find()->all();

        return $this->render('index', [
            'inconsistencias' => $inconsistencias,
			'inconsistencia' => 'active',
        ]);
    }

    /**
     * Displays a single InconsistenciaGeneral model.
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
     * Creates a new InconsistenciaGeneral model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InconsistenciaGeneral();
		$inconsistencias = InconsistenciaGeneral::find()->all();
        $maestras = MaestraProveedor::find()->all();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

			return $this->redirect('create');
			
        } else {
			
            return $this->render('create', [
                'model' => $model,
				'inconsistencias' => $inconsistencias,
			    'inconsistencia' => 'active',
				'maestras' => $maestras,
            ]);
        }
    }

    /**
     * Updates an existing InconsistenciaGeneral model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$inconsistencias = InconsistenciaGeneral::find()->all();
        $maestras = MaestraProveedor::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          
		  return $this->redirect('create');
		  
        } else {
            return $this->render('update', [
                'model' => $model,
				'inconsistencias' => $inconsistencias,
			    'inconsistencia' => 'active',
				'maestras' => $maestras,				
            ]);
        }
    }

    /**
     * Deletes an existing InconsistenciaGeneral model.
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
     * Finds the InconsistenciaGeneral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InconsistenciaGeneral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InconsistenciaGeneral::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
