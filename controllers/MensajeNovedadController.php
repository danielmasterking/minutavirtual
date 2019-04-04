<?php

namespace app\controllers;

use Yii;
use app\models\MensajeNovedad;
use app\models\ValorNovedad;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers;
use yii\helpers\Json;
use \yii\web\Response;
use yii\filters\AccessControl;

/**
 * MensajeNovedadController implements the CRUD actions for MensajeNovedad model.
 */
class MensajeNovedadController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'Mensaje', 'View', 'Create', 'Update', 'Delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'Mensaje', 'View', 'Create', 'Update', 'Delete'],
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
     * Lists all MensajeNovedad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $mensajes = MensajeNovedad::find()->orderBy(['mensaje' => SORT_ASC])->all();

        return $this->render('index', [
            'mensajes' => $mensajes,
        ]);
    }
	
	public function actionMensaje(){
		
        $out = [];
        $valor = '1';
        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
              
                $valor = $parents[0];
				
                $mensajes = MensajeNovedad::find()->where(['valor_novedad_id' => $valor])
                                              ->all(); 
                                             

                $data =  array();

                foreach ($mensajes as $key) {
                          
                  $data [] = array('id' => $key->id, 'name' => $key->mensaje);						  
                      
                }                         
                
                $value = (count($data) === 0) ? ['' => ''] : $data; 
                //$value[0]['options'] = array('selected' => 'selected');
				$selected = (count($data) === 0) ? '' : $data[0]['id']; 
				
                $out = $value; 
                
                echo Json::encode(['output'=> $out, 'selected' => $selected]);
                return;
            }


        }

        echo Json::encode(['output'=>'', 'selected'=>'']);		
		
		
	}

    /**
     * Displays a single MensajeNovedad model.
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
     * Creates a new MensajeNovedad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MensajeNovedad();
		$valores = ValorNovedad::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
				'valores' => $valores,
            ]);
        }
    }

    /**
     * Updates an existing MensajeNovedad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$valores = ValorNovedad::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
				'valores' => $valores,
            ]);
        }
    }

    /**
     * Deletes an existing MensajeNovedad model.
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
     * Finds the MensajeNovedad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MensajeNovedad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MensajeNovedad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
