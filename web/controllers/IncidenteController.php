<?php

namespace app\controllers;

use Yii;
use app\models\Incidente;
use app\models\Novedad;
use app\models\AreaDependencia;
use app\models\ZonaDependencia;
use app\models\FotoIncidente;
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
 * IncidenteController implements the CRUD actions for Incidente model.
 */
class IncidenteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'ViewFromCordinador', 'Pdf', 'Create', 'Update', 'Delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'ViewFromCordinador', 'Pdf', 'Create', 'Update', 'Delete'],
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
     * Lists all Incidente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Incidente::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Incidente model.
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
		
		$pdf->filename = 'Incidente_'.$model->fecha.'_'.$model->novedad->nombre.'.pdf';
		
		$pdf->content = $this->renderPartial('_pdf',['model' => $model],true);
        
		
		$pdf->destination = Pdf::DEST_DOWNLOAD ;
		
		return $pdf->render();
		
		//return $this->redirect('view', ['id' => $id,]);
		
	}		

    /**
     * Creates a new Incidente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Incidente();
        Yii::$app->session->setTimeout(5400);
	    $novedades = Novedad::find()->where(['tipo' => 'I'])->orderBy(['nombre' => SORT_ASC])->all();
		$dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
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
			
			
			  $fecha_real_visita = strtotime('+1 day' , strtotime ( $model->fecha ));
			  $fecha_real_visita = date('Y-m-d',$fecha_real_visita);
			  $model->setAttribute('fecha',$fecha_real_visita);
			  $model->save(); 
			
			
			/*********************** Validar Imagen ****************/
			$images = UploadedFile::getInstances($model, 'image');
			$image_incidente = UploadedFile::getInstance($model, 'image2');
			//VarDumper::dump($images);
			
			foreach($images as $image){

				  if($image !== null)
				  {
					  $foto_incidente = new FotoIncidente();	
					  $ext = end((explode(".", $image->name)));
				      $name = date('Ymd').rand(1, 10000).''.$image->name;
				      $path = Yii::$app->params['uploadPath'] . $name;
				      $foto_incidente->setAttribute('imagen',$shortPath. $name);
				      $foto_incidente->setAttribute('incidente_id',$model->id);
					  $image->saveAs($path);
					  $foto_incidente->save();

				  }

		
			}
			
			if($image_incidente != null){
				
				$ext = end((explode(".", $image_incidente->name)));
				$name = date('Ymd').rand(1, 10000).''.$image_incidente->name;
				$path = Yii::$app->params['uploadPath'] . $name;
				$model->setAttribute('imagen', $shortPath. $name);
				$image_incidente->saveAs($path);
			    $model->save();
				
			}
			

            $model = new Incidente();
			return $this->render('create', [
                'model' => $model,
				'novedades' => $novedades,
				'dependencias' => $dependencias,
				'marcasUsuario' => $marcasUsuario,
				'distritosUsuario' => $distritosUsuario,
				'zonasUsuario' => $zonasUsuario,
				'incidente' => 'active',
				'done' => '200',
            ]);
			
			
			
        } else {
            return $this->render('create', [
                'model' => $model,
				'novedades' => $novedades,
				'dependencias' => $dependencias,
				'marcasUsuario' => $marcasUsuario,
				'distritosUsuario' => $distritosUsuario,
				'incidente' => 'active',
				'zonasUsuario' => $zonasUsuario,
				
				//'zonas' => $zonas,
            ]);
        }
    }

    /**
     * Updates an existing Incidente model.
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
     * Deletes an existing Incidente model.
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
     * Finds the Incidente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Incidente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Incidente::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
