<?php

namespace app\controllers;

use Yii;
use app\models\Capacitacion;
use app\models\CapacitacionDependencia;
use yii\data\ActiveDataProvider;
use app\models\Novedad;
use app\models\CentroCosto;
use app\models\Usuario;
use app\models\CapacitacionInstructor;
use yii\web\Controller;
use kartik\mpdf\Pdf;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;
use yii\filters\AccessControl;

/**
 * CapacitacionController implements the CRUD actions for Capacitacion model.
 */
class CapacitacionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        	'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','ViewFromCordinador','pdf','Personales','create','update',
                           'UpdateFromCordinador','delete','DeleteFromCordinador'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','ViewFromCordinador','pdf','Personales','create','update',
                        			  'UpdateFromCordinador','delete','DeleteFromCordinador'],
                        'roles' => ['@'],//para usuarios logueados
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
     * Lists all Capacitacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Capacitacion::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Capacitacion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$dependencia)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
			'dependencia' => $dependencia,
        ]);
    }
	
	 public function actionViewFromCordinador($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
			
        ]);
    }
	
	public function actionPdf($id){
		
		$model = $this->findModel($id);
		
		$pdf = Yii::$app->pdf;
		
		$pdf->filename = 'Capacitacion_'.$model->fecha.'_'.$model->novedad->nombre.'.pdf';
		
		$pdf->content = $this->renderPartial('_pdf',['model' => $model],true);
        
		
		$pdf->destination = Pdf::DEST_DOWNLOAD ;
		
		return $pdf->render();
		
		//return $this->redirect('view', ['id' => $id,]);
		
	}
	
	public function actionPersonales(){
		
		$usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
		$capacitaciones = Capacitacion::find()->where(['usuario' => $usuario ])->orderBy(['id' => SORT_DESC])->all();
		
		return $this->render('personales', [
                'capacitaciones' => $capacitaciones,
				'personales' => 'active',
            ]);
	}

    /**
     * Creates a new Capacitacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   Yii::$app->session->setTimeout(5400);	
		date_default_timezone_set ( 'America/Bogota');
        $model = new Capacitacion();
		$array_post = Yii::$app->request->post();
		$capacitacion_dependencia = new CapacitacionDependencia();
		$novedades = Novedad::find()->where(['tipo' => 'C'])->orderBy(['nombre' => SORT_ASC])->all();
		$dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
		$cordinadores = Usuario::find()->orderBy(['nombres' => SORT_ASC])->all();
		Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';
		$usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
		$zonasUsuario = array();
		$marcasUsuario = array();
		$distritosUsuario = array();
		
		if($usuario != null){
		  
          $zonasUsuario = $usuario->zonas;
          $marcasUsuario = $usuario->marcas;
          $distritosUsuario = $usuario->distritos;			  
			
		}

        if ($model->load(Yii::$app->request->post())) {
         
		 $image = UploadedFile::getInstance($model, 'image');
		 $file = UploadedFile::getInstance($model, 'file');
		 
		 if($image !== null)
		 {
			  $model->foto = $image->name;
			  $ext = end((explode(".", $image->name)));
			  $name = date('Ymd').rand(1, 10000).''.$model->foto;
			  $path = Yii::$app->params['uploadPath'] . $name;
			  $model->foto = $shortPath. $name;
		 }
		 
		 if($model->save()){
			 
			  $fecha_real_visita = strtotime('+1 day' , strtotime ( $model->fecha_capacitacion ));
			  $fecha_real_visita = date('Y-m-d',$fecha_real_visita);
			  $model->setAttribute('fecha_capacitacion',$fecha_real_visita);
			  $model->save(); 

		   if($image !== null)
		  {
			   $image->saveAs($path);

		  }

		 }	
		 
		  if($file !== null)
		 {
			  $model->lista = $file->name;
			  $ext = end((explode(".", $file->name)));
			  $name = date('Ymd').rand(1, 10000).''.$model->lista;
			  $path = Yii::$app->params['uploadPath'] . $name;
			  $model->lista = $shortPath. $name;
		 }
		 
		 if($model->save()){

			   if($file !== null)
			  {
				   $file->saveAs($path);

			  }

		 }	
		 
		 /******  guardar capacitaciones dependencias  **********/
		 
		    if($model != null){
				
				//validar si todas está marcado
				$todas = array_key_exists('todas',$array_post) ? $array_post['todas'] : '';
				//VarDumper::dump($todas);				
				if($todas != ''){
					
					//guardar instructor y todas las dependencias a su cargo
					//guardar instructor capacitación
					
					$coord = array_key_exists('instructor',$array_post) ? $array_post['instructor'] : '';
					
					if($coord != ''){
						
						$instructor_model = new CapacitacionInstructor();					
						$instructor_model->setAttribute('instructor',$coord);
						$instructor_model->setAttribute('capacitacion_id',$model->id);
						$instructor_model->save();						
						
					}
								
					$instructor = Usuario::findOne($coord);
					$zonasInstructor = array();
					
					if($instructor != null){
					  
					  $zonasInstructor = $instructor->zonas;		  
						
					}
					
					
					$ciudades_zonas = array();

					foreach($zonasInstructor as $zona){
						
						 $ciudades_zonas [] = $zona->zona->ciudades;	
						
					}

					$ciudades_permitidas = array();

					foreach($ciudades_zonas as $ciudades){
						
						foreach($ciudades as $ciudad){
							
							$ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
							
						}
						
					}

					foreach($dependencias as $value){
						
						if(in_array($value->ciudad_codigo_dane,$ciudades_permitidas)){
							
						    $modelo_capacitacion_dep = new CapacitacionDependencia();
							  
							$modelo_capacitacion_dep->setAttribute('centro_costo_codigo', $value->codigo);
							$cantidad_dep = 0;
							$modelo_capacitacion_dep->setAttribute('cantidad', $cantidad_dep);
							$modelo_capacitacion_dep->setAttribute('capacitacion_id', $model->id);
							$modelo_capacitacion_dep->save();							   
						   
						   
						}
						
						
					}
					
					
					
				}else{
					
					
					$coord = array_key_exists('instructor',$array_post) ? $array_post['instructor'] : '';
					$asis = array_key_exists('asistentes',$array_post) ? $array_post['asistentes'] : 0;
					
					if($coord != ''){
						
						$instructor_model = new CapacitacionInstructor();					
						$instructor_model->setAttribute('instructor',$coord);
						$instructor_model->setAttribute('asistentes',$asis);
						$instructor_model->setAttribute('capacitacion_id',$model->id);
						$instructor_model->save();						
						
					}else{
						
					//guardar instructor capacitación
					$instructor_model = new CapacitacionInstructor();
					
					$instructor_model->setAttribute('instructor',$usuario->usuario);
					$instructor_model->setAttribute('capacitacion_id',$model->id);
					$instructor_model->save();
						
						
					}
					

					
					
					//VarDumper::dump($array_post);
					//obtener cantidad de dependencia
					$cantidad = array_key_exists('cantidad', $array_post) ? $array_post['cantidad'] : 0;
					if($cantidad > 0){
						
						//guardar capacitacion dependencia
						for($i = 1; $i <= $cantidad; $i++){
							
							$modelo_capacitacion_dep = new CapacitacionDependencia();
							$dependencia = array_key_exists('sel-dep-'.$i,$array_post) ? $array_post['sel-dep-'.$i] : 0;
							
							if($dependencia != 0){
							  
								$modelo_capacitacion_dep->setAttribute('centro_costo_codigo', $dependencia);
								$cantidad_dep = $array_post['txt-cant-'.$i];
								$modelo_capacitacion_dep->setAttribute('cantidad', $cantidad_dep);
								$modelo_capacitacion_dep->setAttribute('capacitacion_id', $model->id);
								$modelo_capacitacion_dep->save();	
							}
							
							
						}
						
					}
					
					
				}
		
			}
		 
		 /********************************************************/
		 
		 
		 $model = new Capacitacion();
		 return $this->render('create', [
                'model' => $model,
				'dependencias' => $dependencias,
				'novedades' => $novedades,
				'cordinadores' => $cordinadores,
				'zonasUsuario' => $zonasUsuario,
				'marcasUsuario' => $marcasUsuario,
			    'distritosUsuario' => $distritosUsuario,
				'nuevo' => 'active',
				'done' => '200',
				
            ]);
        } else {
		
            return $this->render('create', [
                'model' => $model,
				'dependencias' => $dependencias,
				'novedades' => $novedades,
				'zonasUsuario' => $zonasUsuario,
			    'marcasUsuario' => $marcasUsuario,
			    'distritosUsuario' => $distritosUsuario,
                'nuevo' => 'active',				
				'cordinadores' => $cordinadores,
            ]);
        }
    }

    /**
     * Updates an existing Capacitacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        Yii::$app->session->setTimeout(5400);	
		$array_post = Yii::$app->request->post();
		$capacitacion_dependencia = new CapacitacionDependencia();
		$novedades = Novedad::find()->where(['tipo' => 'C'])->orderBy(['nombre' => SORT_ASC])->all();
		$dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
		$cordinadores = Usuario::find()->orderBy(['nombres' => SORT_ASC])->all();
		Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';
		$usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
		$zonasUsuario = array();
		$marcasUsuario = array();
		$distritosUsuario = array();
		
		if($usuario != null){
		  
          $zonasUsuario = $usuario->zonas;
          $marcasUsuario = $usuario->marcas;
          $distritosUsuario = $usuario->distritos;			  
			
		}
        if ($model->load(Yii::$app->request->post())) {
			
         
			 $image = UploadedFile::getInstance($model, 'image');
			 $file = UploadedFile::getInstance($model, 'file');
			 
			 if($image !== null)
			 {
				  $model->foto = $image->name;
				  $ext = end((explode(".", $image->name)));
				  $name = date('Ymd').rand(1, 10000).''.$model->foto;
				  $path = Yii::$app->params['uploadPath'] . $name;
				  $model->foto = $shortPath. $name;
			 }
			 
			 if($model->save()){

			   if($image !== null)
			  {
				   $image->saveAs($path);

			  }

			 }	
			 
			  if($file !== null)
			 {
				  $model->lista = $file->name;
				  $ext = end((explode(".", $file->name)));
				  $name = date('Ymd').rand(1, 10000).''.$model->lista;
				  $path = Yii::$app->params['uploadPath'] . $name;
				  $model->lista = $shortPath. $name;
			 }
			 
			 if($model->save()){

				   if($file !== null)
				  {
					   $file->saveAs($path);

				  }

			 }         			 
 
			  return $this->render('update', [
                'model' => $model,
			    'dependencias' => $dependencias,
				'novedades' => $novedades,
				'zonasUsuario' => $zonasUsuario,
			    'marcasUsuario' => $marcasUsuario,
			    'distritosUsuario' => $distritosUsuario,
                'nuevo' => 'active',				
				'cordinadores' => $cordinadores,
				'done' => '200',
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
			    'dependencias' => $dependencias,
				'novedades' => $novedades,
				'zonasUsuario' => $zonasUsuario,
			    'marcasUsuario' => $marcasUsuario,
			    'distritosUsuario' => $distritosUsuario,
                'nuevo' => 'active',				
				'cordinadores' => $cordinadores,
            ]);
        }
    }
	
	
    public function actionUpdateFromCordinador($id)
    {
        $model = $this->findModel($id);
        Yii::$app->session->setTimeout(5400);	
		$array_post = Yii::$app->request->post();
		$capacitacion_dependencia = new CapacitacionDependencia();
		$novedades = Novedad::find()->where(['tipo' => 'C'])->orderBy(['nombre' => SORT_ASC])->all();
		$dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
		$cordinadores = Usuario::find()->orderBy(['nombres' => SORT_ASC])->all();
		Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';
		$usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
		$zonasUsuario = array();
		$marcasUsuario = array();
		$distritosUsuario = array();
		
		if($usuario != null){
		  
          $zonasUsuario = $usuario->zonas;
          $marcasUsuario = $usuario->marcas;
          $distritosUsuario = $usuario->distritos;			  
			
		}
        if ($model->load(Yii::$app->request->post())) {
			
         
			 $image = UploadedFile::getInstance($model, 'image');
			 $file = UploadedFile::getInstance($model, 'file');
			 
			 if($image !== null)
			 {
				  $model->foto = $image->name;
				  $ext = end((explode(".", $image->name)));
				  $name = date('Ymd').rand(1, 10000).''.$model->foto;
				  $path = Yii::$app->params['uploadPath'] . $name;
				  $model->foto = $shortPath. $name;
			 }
			 
			 if($model->save()){

			   if($image !== null)
			  {
				   $image->saveAs($path);

			  }

			 }	
			 
			  if($file !== null)
			 {
				  $model->lista = $file->name;
				  $ext = end((explode(".", $file->name)));
				  $name = date('Ymd').rand(1, 10000).''.$model->lista;
				  $path = Yii::$app->params['uploadPath'] . $name;
				  $model->lista = $shortPath. $name;
			 }
			 
			 if($model->save()){

				   if($file !== null)
				  {
					   $file->saveAs($path);

				  }

			 }
			  return $this->render('update', [
                'model' => $model,
			    'dependencias' => $dependencias,
				'novedades' => $novedades,
				'zonasUsuario' => $zonasUsuario,
			    'marcasUsuario' => $marcasUsuario,
			    'distritosUsuario' => $distritosUsuario,
                'nuevo' => 'active',				
				'cordinadores' => $cordinadores,
				'done' => '200',
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
			    'dependencias' => $dependencias,
				'novedades' => $novedades,
				'zonasUsuario' => $zonasUsuario,
			    'marcasUsuario' => $marcasUsuario,
			    'distritosUsuario' => $distritosUsuario,
                'nuevo' => 'active',				
				'cordinadores' => $cordinadores,
            ]);
        }
    }	

    /**
     * Deletes an existing Capacitacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id,$dependencia)
    {

        $this->findModel($id)->delete();
         
        return $this->redirect(['centro-costo/capacitacion?id='.$dependencia]);
    }
	
	 public function actionDeleteFromCordinador($id,$usuario)
    {

        $this->findModel($id)->delete();
         
        return $this->redirect(['usuario/capacitacion?id='.$usuario]);
    }

    /**
     * Finds the Capacitacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Capacitacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Capacitacion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
