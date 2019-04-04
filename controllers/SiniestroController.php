<?php

namespace app\controllers;

use Yii;
use app\models\Siniestro;
use app\models\Novedad;
use app\models\AreaDependencia;
use app\models\ZonaDependencia;
use app\models\FotoSiniestro;
use app\models\CentroCosto;
use app\models\Usuario;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
/**
 * SiniestroController implements the CRUD actions for Siniestro model.
 */
class SiniestroController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        	'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'ViewPersonales', 'ViewFromCordinador', 'Personales', 'Create', 'Update', 'Pdf', 'Delete', 
                			'DeleteFromCordinador'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'ViewPersonales', 'ViewFromCordinador', 'Personales', 'Create', 'Update', 'Pdf', 'Delete', 
                					  'DeleteFromCordinador'],
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
     * Lists all Siniestro models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Siniestro::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Siniestro model.
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
	
	 public function actionViewPersonales($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
			//'dependencia' => $dependencia,
        ]);
    }	
	
	 public function actionViewFromCordinador($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
			
        ]);
    }
	
	
	public function actionPersonales(){
		
		Yii::$app->session->setTimeout(5400);
		$usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
		$siniestros = Siniestro::find()->where(['usuario' => $usuario ])->orderBy(['id' => SORT_DESC])->all();
		
		return $this->render('personales', [
                'siniestros' => $siniestros,
				'personales' => 'active',
            ]);
	}
	
	    /**
     * Updates an existing Siniestro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        Yii::$app->session->setTimeout(5400);
		$model = $this->findModel($id);
	    $novedades = Novedad::find()->where(['tipo' => 'S'])->orderBy(['nombre' => SORT_ASC])->all();
		$dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
		$areas = AreaDependencia::find()->orderBy(['nombre' => SORT_ASC])->all();
		//$zonas = ZonaDependencia::find()->orderBy(['nombre' => SORT_ASC])->all();
		$usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
		$zonasUsuario = array();
		$marcasUsuario = array();
		$distritosUsuario = array();
		
		if($usuario != null){
		  
          $zonasUsuario = $usuario->zonas;		
          $marcasUsuario = $usuario->marcas;
          $distritosUsuario = $usuario->distritos;		  
			
		}
		
		Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			  $fecha_real_visita = strtotime('+1 day' , strtotime ( $model->fecha_siniestro ));
			  $fecha_real_visita = date('Y-m-d',$fecha_real_visita);
			  $model->setAttribute('fecha_siniestro',$fecha_real_visita);
			  $model->save(); 
			  
			  $images = UploadedFile::getInstances($model, 'image');
			  
			  foreach($images as $image){

				  if($image !== null)
				  {
					  $foto_siniestro = new FotoSiniestro();	
					  $ext = end((explode(".", $image->name)));
				      $name = date('Ymd').rand(1, 10000).''.$image->name;
				      $path = Yii::$app->params['uploadPath'] . $name;
				      $foto_siniestro->setAttribute('imagen',$shortPath. $name);
				      $foto_siniestro->setAttribute('siniestro_id',$model->id);
					  $image->saveAs($path);
					  $foto_siniestro->save();

				  }

		
			    }
				return $this->render('update', [
					'model' => $model,
					'novedades' => $novedades,
					'dependencias' => $dependencias,
					'areas' => $areas,
					'marcasUsuario' => $marcasUsuario,
					'distritosUsuario' => $distritosUsuario,
					'zonasUsuario' => $zonasUsuario,
					'nuevo' => 'active',
					'done' => '200',
				]);	
             

        } else {	
				return $this->render('create', [
					'model' => $model,
					'novedades' => $novedades,
					'dependencias' => $dependencias,
					'areas' => $areas,
					'marcasUsuario' => $marcasUsuario,
					'distritosUsuario' => $distritosUsuario,
					'nuevo' => 'active',
					'zonasUsuario' => $zonasUsuario,
					//'zonas' => $zonas,
				]);
        }
    }

    /**
     * Creates a new Siniestro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->session->setTimeout(5400);
		$model = new Siniestro();
	    $novedades = Novedad::find()->where(['tipo' => 'S'])->orderBy(['nombre' => SORT_ASC])->all();
		$dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
		$areas = AreaDependencia::find()->orderBy(['nombre' => SORT_ASC])->all();
		//$zonas = ZonaDependencia::find()->orderBy(['nombre' => SORT_ASC])->all();
		$usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
		$zonasUsuario = array();
		$marcasUsuario = array();
		$distritosUsuario = array();
		
		if($usuario != null){
		  
          $zonasUsuario = $usuario->zonas;		
          $marcasUsuario = $usuario->marcas;
          $distritosUsuario = $usuario->distritos;		  
			
		}
		
		Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';

        if ( $model->load(Yii::$app->request->post()) && $model->save()) {
			
			
              $fecha_real_visita = strtotime('+1 day' , strtotime ( $model->fecha_siniestro ));
			  $fecha_real_visita = date('Y-m-d',$fecha_real_visita);
			  $model->setAttribute('fecha_siniestro',$fecha_real_visita);
			  $model->save(); 
					
			/*********************** Validar Imagen ****************/
			$images = UploadedFile::getInstances($model, 'image');
			//VarDumper::dump($images);
			
			foreach($images as $image){

				  if($image !== null)
				  {
					  $foto_siniestro = new FotoSiniestro();	
					  $ext = end((explode(".", $image->name)));
				      $name = date('Ymd').rand(1, 10000).''.$image->name;
				      $path = Yii::$app->params['uploadPath'] . $name;
				      $foto_siniestro->setAttribute('imagen',$shortPath. $name);
				      $foto_siniestro->setAttribute('siniestro_id',$model->id);
					  $image->saveAs($path);
					  $foto_siniestro->save();

				  }

		
			}

            $model = new Siniestro();
			return $this->render('create', [
                'model' => $model,
				'novedades' => $novedades,
				'dependencias' => $dependencias,
				'areas' => $areas,
				'marcasUsuario' => $marcasUsuario,
				'distritosUsuario' => $distritosUsuario,
				'zonasUsuario' => $zonasUsuario,
				'nuevo' => 'active',
				'done' => '200',
            ]);
			
        } else {
            return $this->render('create', [
                'model' => $model,
				'novedades' => $novedades,
				'dependencias' => $dependencias,
				'areas' => $areas,
				'marcasUsuario' => $marcasUsuario,
				'distritosUsuario' => $distritosUsuario,
				'nuevo' => 'active',
				'zonasUsuario' => $zonasUsuario,
				//'zonas' => $zonas,
            ]);
        }
    }
	
	public function actionPdf($id){
		
		$model = $this->findModel($id);
		
		$pdf = Yii::$app->pdf;
		
		$pdf->filename = 'Siniestro_'.$model->fecha.'_'.$model->novedad->nombre.'.pdf';
		
		$pdf->content = $this->renderPartial('_pdf',['model' => $model],true);
        
		
		$pdf->destination = Pdf::DEST_DOWNLOAD ;
		
		return $pdf->render();
		
		//return $this->redirect('view', ['id' => $id,]);
		
	}

    /**
     * Deletes an existing Siniestro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id,$dependencia)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['centro-costo/siniestro?id='.$dependencia]);
    }
	
	 public function actionDeleteFromCordinador($id,$usuario)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['usuario/siniestro?id='.$usuario]);
    }

    /**
     * Finds the Siniestro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Siniestro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Siniestro::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
