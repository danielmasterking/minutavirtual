<?php

namespace app\controllers;

use Yii;
use app\models\Formato;
use app\models\Microactividad;
use app\models\Novedad;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * FormatoController implements the CRUD actions for Formato model.
 */
class FormatoController extends Controller
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
     * Lists all Formato models.
     * @return mixed
     */
    public function actionIndex()
    {
        $metricas = Formato::find()->orderBy(['nombre' => SORT_ASC])->all();

        return $this->render('index', [
            'metricas' => $metricas,
			'formato' => 'active',
        ]);
    }

    /**
     * Displays a single Formato model.
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
     * Creates a new Formato model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Formato();
		$microactividades = Microactividad::find()->orderBy(['nombre' => SORT_ASC])->all();
		$novedades = Novedad::find()->orderBy(['nombre' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
			    'microactividades' => $microactividades,
				'formato' => 'active',	
				'novedades' => $novedades,
            ]);
        }
    }

    /**
     * Updates an existing Formato model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $microactividades = Microactividad::find()->orderBy(['nombre' => SORT_ASC])->all();
        $novedades = Novedad::find()->orderBy(['nombre' => SORT_ASC])->all();
		$array_post = Yii::$app->request->post();
		
		$primaryConnection = Yii::$app->db;
		
		$sql = "SELECT CONCAT(TABLE_NAME,' - ',COLUMN_NAME) AS COLUMNAS 
		          FROM COLUMNS 
				  WHERE TABLE_SCHEMA = 'exito'";
				  
		$columnasCommand = $primaryConnection->createCommand($sql);		  
		$columnas = $columnasCommand->queryAll();
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
			    'microactividades' => $microactividades,
				'novedades' => $novedades,
				'formato' => 'active',
                'columnas' => $columnas,				
            ]);
        }
    }

    /**
     * Deletes an existing Formato model.
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
     * Finds the Formato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Formato the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Formato::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
