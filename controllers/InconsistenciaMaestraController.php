<?php

namespace app\controllers;

use Yii;
use app\models\InconsistenciaMaestra;
use app\models\MaestraProveedor;
use app\models\DetalleMaestra;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * InconsistenciaMaestraController implements the CRUD actions for InconsistenciaMaestra model.
 */
class InconsistenciaMaestraController extends Controller
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
     * Lists all InconsistenciaMaestra models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => InconsistenciaMaestra::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InconsistenciaMaestra model.
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
     * Creates a new InconsistenciaMaestra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InconsistenciaMaestra();
		$inconsistencias = InconsistenciaMaestra::find()->all();
        $maestras = MaestraProveedor::find()->all();
		
        if ($model->load(Yii::$app->request->post())) {
			
			$productos = DetalleMaestra::find()->where(['maestra_proveedor_id' => $model->maestra_proveedor_id, 'estado' => 'A'])->orderBy(['id' => SORT_ASC])->all();
			
			foreach($productos as $key){
				
				$modelo = new InconsistenciaMaestra();
				$modelo->setAttribute('maestra_proveedor_id', $model->maestra_proveedor_id);
				$modelo->setAttribute('material', $key->material);
				$modelo->setAttribute('descripcion',$model->descripcion);
				$modelo->save();
				
			}
			
			
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
     * Updates an existing InconsistenciaMaestra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InconsistenciaMaestra model.
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
     * Finds the InconsistenciaMaestra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InconsistenciaMaestra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InconsistenciaMaestra::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
