<?php

namespace app\controllers;

use Yii;
use app\models\Presupuesto;
use app\models\Usuario;
use app\models\AuditoriaPresupuesto;
use app\models\CentroCosto;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\filters\AccessControl;
/**
 * PresupuestoController implements the CRUD actions for Presupuesto model.
 */
class PresupuestoController extends Controller
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
     * Lists all Presupuesto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Presupuesto::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Presupuesto model.
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
     * Creates a new Presupuesto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->session->setTimeout(5400);	
	    $model = new Presupuesto();
        $dependencias = CentroCosto::find()->where(['estado' => 'D'])->orderBy(['nombre' => SORT_ASC])->all();
        $array_post = Yii::$app->request->post();
		$usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
		$presupuestos_asignados = Presupuesto::find()->all();
		$temporal = array();
		$fecha_actual = date('Y-m-d',time());
		
		/* Validar dependencias con presupuesto asignado*/
		foreach($dependencias as $dep){
             
			 $sw = false;             
			 
             foreach($presupuestos_asignados as $asig){
				 
				 if($dep->codigo === $asig->centro_costo_codigo){
					
                    $sw = true;
					break;
					 
				 }
				 
			 }

              if($sw === false){
				  
				  $temporal [] = $dep;
				  
				  
			  }			 
			
		}
		
		
		/*Ajustar contenido de dependencias*/
		$dependencias = $temporal;
		
		$llaves = array();
		
		if(isset($array_post)){
			
			
			$llaves = array_keys($array_post);
			//VarDumper::dump($array_post);
            date_default_timezone_set ( 'America/Bogota');
            $fecha = date('Y-m-d H:i:s',time());
			$dep = '';
			
			foreach($llaves as $key){
				
				
				if(strpos($key,'txt-dep') !== false) {
					
					
					$tmp = explode('-',$key);
					$dep = $tmp[2];
					
				}
				
				if(strpos($key,'txt-valor') !== false) {
					
					
				    $suma_seguridad = array_key_exists('seguridad',$array_post) ? true: false;
				    $suma_riesgo = array_key_exists('riesgos',$array_post) ? true : false;
				    $tmp = explode('-',$key);
					$id_actual = $tmp[2];					
					$actualizar = $this->findModel($id_actual);	
					$audModel = new AuditoriaPresupuesto();
					$audModel->setAttribute('fecha',$fecha);
					$audModel->setAttribute('usuario',$usuario->usuario);
					$audModel->setAttribute('operacion','ADICIONÓ');
					$audModel->setAttribute('centro_costo_codigo',$dep);
					
					
					if($suma_seguridad){
						
							
							if($array_post['txt-valor-'.$id_actual] != 0){
								//VarDumper::dump($array_post['txt-valor-'.$id_actual]);
            					$total = $actualizar->presupuesto_seguridad_actual + $array_post['txt-valor-'.$id_actual];
								$actualizar->setAttribute('presupuesto_seguridad_actual',$total);
								$actualizar->save();						
								$audModel->setAttribute('valor',$array_post['txt-valor-'.$id_actual]);
								$audModel->setAttribute('area','SEGURIDAD');
								
								$audModel->save();
									
								
							}
							
							$dep = '';
						
						
					}else{
						
						if($suma_riesgo){
							
							
							if($array_post['txt-valor-'.$id_actual] != 0){
								//VarDumper::dump($array_post['txt-valor-'.$id_actual]);
								$total = $actualizar->presupuesto_riesgo_actual + $array_post['txt-valor-'.$id_actual];
								$actualizar->setAttribute('presupuesto_riesgo_actual',$total);
								$actualizar->save();
								$audModel->setAttribute('valor',$array_post['txt-valor-'.$id_actual]);
								$audModel->setAttribute('area','RIESGO');
								$audModel->save();
								
							
							
							}
							

							$dep = '';
							
						}
						
					}
					
					
					$actualizar->setAttribute('presupuesto_actual',$actualizar->presupuesto_riesgo_actual + $actualizar->presupuesto_seguridad_actual);
					$actualizar->save();
					
					//
					
					


					
				}
				
				
			}
			
			
			
			
			
		}
		
		
		
		
		
		if ($model->load(Yii::$app->request->post()) ) {
            
			
			//verificar que no exista dependencia en 
			//Desarrollo con presupuesto Asignado previamente.
			
			$existe_model = Presupuesto::find()->where(['centro_costo_codigo' => $model->centro_costo_codigo])->one();
			
			if($existe_model == null){
			    
				/*$model->setAttribute('fecha_asignacion',$fecha_actual);
			    $model->save();*/						
				
				$model->setAttribute('presupuesto_seguridad_actual',$model->presupuesto_seguridad);
				$model->setAttribute('presupuesto_riesgo_actual',$model->presupuesto_riesgo);
				$model->setAttribute('presupuesto_actual',$model->presupuesto_seguridad + $model->presupuesto_riesgo);
				$model->save();		

				$model = new Presupuesto();
				$presupuestos = Presupuesto::find()->where(['estado_dependencia' => 'D'])->all();
				$presupuestos_asignados = Presupuesto::find()->all();
			/*************************************************************/
					$temporal = array();
					
					/* Validar dependencias con presupuesto asignado*/
					foreach($dependencias as $dep){
						 
						 $sw = false;             
						 
						 foreach($presupuestos_asignados as $asig){
							 
							 if($dep->codigo === $asig->centro_costo_codigo){
								
								$sw = true;
								break;
								 
							 }
							 
						 }

						  if($sw === false){
							  
							  $temporal [] = $dep;
							  
							  
						  }			 
						
					}
					
					
					/*Ajustar contenido de dependencias*/
					$dependencias = $temporal;
			/***************************************************/
				
				return $this->render('create', [
					'model' => $model,
					'dependencias' => $dependencias,
					'presupuesto' => 'active',
					'done' => '200',
					'presupuestos' => $presupuestos,
					'llaves' => $llaves,
				]);				
				
			}
			
			
			
			
			
			$model = new Presupuesto();
			$presupuestos = Presupuesto::find()->where(['estado_dependencia' => 'D'])->all();
		
			return $this->render('create', [
				'model' => $model,
				'dependencias' => $dependencias,
				'presupuesto' => 'active',
				'done' => '500',
				'presupuestos' => $presupuestos,
				'llaves' => $llaves,
			]);		

			
        } else {
			
			
			//Verificar dependendencias con fechas 
			$actual_time = time();			
			$dos_meses = 5184000; 
			
			 $presupuestos = Presupuesto::find()->where(['estado_dependencia' => 'D'])->all();
            
			foreach($presupuestos as $key){
				
				if($key->fecha_asignacion != null || $key->fecha_asignacion != '' ){

					$temp_time = strtotime($key->fecha_asignacion);
					
					if($actual_time >= $temp_time){
					//  if($key->fecha_asignacion == $fecha_actual){	
						$key->setAttribute('estado_dependencia','A');
						$key->save();
						//cambiar estado de dependencia a abierta
						$model_cc = CentroCosto::find()->where(['codigo' => $key->centro_costo_codigo ])->one();
						$model_cc->setAttribute('estado','A');
						$model_cc->save();
						
					}					
					
				}
				

				
			}
			
			$presupuestos = Presupuesto::find()->where(['estado_dependencia' => 'D'])->all();
			
			return $this->render('create', [
                'model' => $model,
				'dependencias' => $dependencias,
				'presupuesto' => 'active',
				'presupuestos' => $presupuestos,
				'llaves' => $llaves,
            ]);
        }
    }

    /**
     * Updates an existing Presupuesto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $dependencias = CentroCosto::find()->where(['estado' => 'D'])->orderBy(['nombre' => SORT_ASC])->all();
        $array_post = Yii::$app->request->post();
		$usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        
		$presupuestos_asignados = Presupuesto::find()->all();
		$temporal = array();
		$fecha_actual = date('Y-m-d',time());
		
		/* Validar dependencias con presupuesto asignado*/
		foreach($dependencias as $dep){
             
			 $sw = false;             
			 
             foreach($presupuestos_asignados as $asig){
				 
				 if($dep->codigo === $asig->centro_costo_codigo){
					
                    $sw = true;
					break;
					 
				 }
				 
			 }

              if($sw === false){
				  
				  $temporal [] = $dep;
				  
				  
			  }			 
			
		}
		
		
		/*Ajustar contenido de dependencias*/
		$dependencias = $temporal;		
		
		$llaves = array();
		
		if(isset($array_post)){
			
			
			$llaves = array_keys($array_post);
			//VarDumper::dump($array_post);
            date_default_timezone_set ( 'America/Bogota');
            $fecha = date('Y-m-d H:i:s',time());
			$dep = '';

		
		}
	
		if ($model->load(Yii::$app->request->post()) ) {

		    $model->save();
			  $fecha_real_visita = strtotime('+1 day' , strtotime ( $model->fecha_asignacion ));
			  $fecha_real_visita = date('Y-m-d',$fecha_real_visita);
			  $model->setAttribute('fecha_asignacion',$fecha_real_visita);
			  $model->save(); 
			
			$presupuestos_asignados = Presupuesto::find()->all();
			$temporal = array();
			$fecha_actual = date('Y-m-d',time());
			
			/* Validar dependencias con presupuesto asignado*/
			foreach($dependencias as $dep){
				 
				 $sw = false;             
				 
				 foreach($presupuestos_asignados as $asig){
					 
					 if($dep->codigo === $asig->centro_costo_codigo){
						
						$sw = true;
						break;
						 
					 }
					 
				 }

				  if($sw === false){
					  
					  $temporal [] = $dep;
					  
					  
				  }			 
				
			}
			
			
			/*Ajustar contenido de dependencias*/
			$dependencias = $temporal;			
			
			
			$model = new Presupuesto();
			$presupuestos = Presupuesto::find()->where(['estado_dependencia' => 'D'])->all();
		
			return $this->render('create', [
				'model' => $model,
				'dependencias' => $dependencias,
				'presupuesto' => 'active',
				'presupuestos' => $presupuestos,
				'llaves' => $llaves,
			]);		

			
        } else {
			
			 $presupuestos = Presupuesto::find()->where(['estado_dependencia' => 'D'])->all();
            return $this->render('update', [
                'model' => $model,
				'dependencias' => $dependencias,
				'presupuesto' => 'active',
				'presupuestos' => $presupuestos,
				'llaves' => $llaves,
            ]);
        }
    }

    /**
     * Deletes an existing Presupuesto model.
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
     * Finds the Presupuesto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Presupuesto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Presupuesto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
