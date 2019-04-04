<?php

namespace app\controllers;

use Yii;
use app\models\Responsable;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use \yii\web\Response;
use yii\filters\AccessControl;

/**
 * ResponsableController implements the CRUD actions for Responsable model.
 */
class ResponsableController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'Create', 'Update', 'Delete', 'Dependencia'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'Create', 'Update', 'Delete', 'Dependencia'],
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
     * Lists all Responsable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Responsable::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Responsable model.
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
     * Creates a new Responsable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
	 * $id = codigo de depencia del responsable
     */
    public function actionCreate($id)
    {
        $model = new Responsable();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['centro-costo/informacion','id' => $id]);
        } else {
            return $this->render('create', [
                'model' => $model,
				'id' => $id,
            ]);
        }
    }

    /**
     * Updates an existing Responsable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$codigo)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             return $this->redirect(['centro-costo/informacion','id' => $codigo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Responsable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id,$codigo)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['centro-costo/informacion','id' => $codigo]);
    }
	
    public function actionDependencia(){
		
        $out = [];
        $valor = '1';
        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
              
                $valor = $parents[0];
				
                $responsables = Responsable::find()->where(['centro_costo_codigo' => $valor])->orderBy(['nombre' => SORT_ASC])
                                              ->all(); 
                                             

                $data =  array();

                foreach ($responsables as $key) {
                          
                  $data [] = array('id' => strtoupper($key->nombre), 'name' => strtoupper($key->nombre));						  
                      
                }       

                $data [] = array('id' => 'OTRO', 'name' => 'OTRO');							
                
                $value = (count($data) === 0) ? ['' => ''] : $data; 

                $out = $value; 
                
                echo Json::encode(['output'=> $out, 'selected'=>'']);
                return;
            }


        }

        echo Json::encode(['output'=>'', 'selected'=>'']);		
		
		
	}

    /**
     * Finds the Responsable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Responsable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Responsable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
