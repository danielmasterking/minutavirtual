<?php

namespace app\controllers;

use Yii;
use app\models\Evento;
use app\models\EventoMarca;
use app\models\EventoDistrito;
use app\models\FotoEvento;
use app\models\Novedad;
use app\models\CentroCosto;
use app\models\Usuario;
use app\models\Marca;
use app\models\Distrito;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;

/**
 * EventoController implements the CRUD actions for Evento model.
 */
class EventoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        	'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'Create', 'Update', 'Delete', 'DeleteFromCordinador', 'Pdf'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'Create', 'Update', 'Delete', 'DeleteFromCordinador', 'Pdf'],
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
     * Lists all Evento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Evento::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Evento model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$modelFoto =  FotoEvento::find()->where(['evento_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model_foto' => $modelFoto,
        ]);
    }

    /**
     * Creates a new Evento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	date_default_timezone_set('America/Bogota');
        $model = new Evento();
		
		$array_post = Yii::$app->request->post();
		Yii::$app->session->setTimeout(5400);	
		$dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
		$usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
		$novedades = Novedad::find()->where(['tipo' => 'E'])->orderBy(['nombre' => SORT_ASC])->all();
		$zonasUsuario = array();
		$marcasUsuario = array();
		$distritosUsuario = array();
		
		Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';
		
		if($usuario != null){
		  
          $zonasUsuario = $usuario->zonas;
          $marcasUsuario = $usuario->marcas;
          $distritosUsuario = $usuario->distritos;			  
			
		}

        if ($model->load(Yii::$app->request->post())) {
			
			
			if($model->centro_costo_codigo == null){
				
				$model->setAttribute('centro_costo_codigo','000');
				$model->setAttribute('cantidad_apoyo','0');
				
			}
			
			 //guardar evento
			 $model->save();
             //VarDumper::dump($model->errors);			 
			
			
			
			/******************* Validar si existen objetos relacionados ***/
			
			$marca = array_key_exists('marca_select', $array_post) ? $array_post['marca_select'] : '';
			$distrito = array_key_exists('distrito_select', $array_post) ? $array_post['distrito_select'] : '';
			
			
			if($marca != ''){
				
				$evento_marca = new EventoMarca();
				$evento_marca->setAttribute('evento_id',$model->id);
				$evento_marca->setAttribute('marca_id',$marca);
				$evento_marca->save();
				
			}
			
			if($distrito != ''){
				
				$evento_distrito = new EventoDistrito();
				$evento_distrito->setAttribute('evento_id', $model->id);
				$evento_distrito->setAttribute('distrito_id', $distrito);
				$evento_distrito->save();
			}
			
			
			/*********************** Validar Imagen ************************/
			$images = UploadedFile::getInstances($model, 'image');
			
			//Iterar sobre imagenes cargadas
			foreach($images as $image){
				
				   if($image !== null)
				  {
					  $foto_evento = new FotoEvento();	
					  $ext = end((explode(".", $image->name)));
				      $name = date('Ymd').rand(1, 10000).''.$image->name;
				      $path = Yii::$app->params['uploadPath'] . $name;
				      $foto_evento->setAttribute('imagen',$shortPath. $name);
				      $foto_evento->setAttribute('evento_id',$model->id);
					  $image->saveAs($path);
					  $foto_evento->save();
					  

				  }

				
			}
            
			
			$model = new Evento();
			return $this->render('create', [
                'model' => $model,
				'evento' => 'active',
				'dependencias' => $dependencias,
				'marcasUsuario' => $marcasUsuario,
				'distritosUsuario' => $distritosUsuario,
				'zonasUsuario' => $zonasUsuario,	
				'novedades' => $novedades,
				'evento' => 'active',
				'done' => '200',
            ]);
			
        } else {
            return $this->render('create', [
                
				'model' => $model,
				'evento' => 'active',
				'dependencias' => $dependencias,
				'marcasUsuario' => $marcasUsuario,
				'distritosUsuario' => $distritosUsuario,
				'novedades' => $novedades,
				'evento' => 'active',
				'zonasUsuario' => $zonasUsuario,	
            ]);
        }
    }

    /**
     * Updates an existing Evento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        Yii::$app->session->setTimeout(5400);
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
     * Deletes an existing Evento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id,$dependencia)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['centro-costo/evento?id='.$dependencia]);
    }
	
	 public function actionDeleteFromCordinador($id,$usuario)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['usuario/evento?id='.$usuario]);
    }

    /**
     * Finds the Evento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Evento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Evento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionPdf($id){
		
		$model = $this->findModel($id);
		$modelFoto =  FotoEvento::find()->where(['evento_id' => $id])->all();
		
		$pdf = Yii::$app->pdf;
		
		$pdf->filename = 'Visita_Solicitud_Activacion_'.$model->fecha.'_'.$model->dependencia->nombre.'.pdf';
		
		$pdf->content = $this->renderPartial('_pdf',['model' => $model, 'model_foto' => $modelFoto],true);
        
		
		$pdf->destination = Pdf::DEST_DOWNLOAD ;
		
		return $pdf->render();
		
		//return $this->redirect('view', ['id' => $id,]);
		
	}
}
