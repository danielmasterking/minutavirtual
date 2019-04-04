<?php

namespace app\controllers;

use Yii;
use app\models\Merma;
use app\models\AreaDependencia;
use app\models\ZonaDependencia;
use app\models\FotoMerma;
use app\models\MaterialMerma;
use app\models\MermaDependencia;
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
 * MermaController implements the CRUD actions for Merma model.
 */
class MermaController extends Controller
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
     * Lists all Merma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Merma::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Merma model.
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
		
		$pdf->filename = 'Merma_'.$model->fecha.'.pdf';
		
		$pdf->content = $this->renderPartial('_pdf',['model' => $model],true);
        
		
		$pdf->destination = Pdf::DEST_DOWNLOAD ;
		
		return $pdf->render();
		
		//return $this->redirect('view', ['id' => $id,]);
		
	}	

    /**
     * Creates a new Merma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $array_post = Yii::$app->request->post();
		$model = new Merma();
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

        if ($model->load(Yii::$app->request->post())) {
			
			
		   $model->setAttribute('material','xxx');
		   $model->save();
           
		   $cantidad_dep = array_key_exists('cantidad-dep', $array_post) ? $array_post['cantidad-dep'] : 0;		   
		   $cantidad_mat = array_key_exists('cantidad-mat', $array_post) ? $array_post['cantidad-mat'] : 0;		   
			
		   $fecha_real_visita = strtotime('+1 day' , strtotime ( $model->fecha ));
		   $fecha_real_visita = date('Y-m-d',$fecha_real_visita);
		   $model->setAttribute('fecha',$fecha_real_visita);
		   
		   $total_recuperado = $model->cantidad * $model->valor;
		   $model->setAttribute('total',$total_recuperado);
		   
		   $model->save(); 
		   
		   
		   
		   $cantidad_dep = array_key_exists('cantidad-dep', $array_post) ? $array_post['cantidad-dep'] : 0;
		   $cantidad_mat = array_key_exists('cantidad-mat', $array_post) ? $array_post['cantidad-mat'] : 0;
		   
		   
		   if($cantidad_dep > 0){
			   
				//guardar capacitacion dependencia
				for($i = 1; $i <= $cantidad_dep; $i++){
					
					$modelo_merma_dep = new MermaDependencia();
					$dependencia = array_key_exists('sel-dep-'.$i,$array_post) ? $array_post['sel-dep-'.$i] : 0;
					
					if($dependencia != 0){
					  
						$modelo_merma_dep->setAttribute('centro_costo_codigo', $dependencia);
						//$cantidad_dep = $array_post['txt-cant-'.$i];
						$modelo_merma_dep->setAttribute('merma_id', $model->id);
						$modelo_merma_dep->save();	
					}
					
					
				}			   
			   
			   
		   }
		   
		   $total_recuperado = 0;
		   if($cantidad_mat > 0){
			   
				//guardar capacitacion dependencia
				for($i = 1; $i <= $cantidad_mat; $i++){
					
					$modelo_merma_dep = new MaterialMerma();
					$material = $array_post['txt-material-'.$i];
					$cantidad = $array_post['txt-cantidad-'.$i];
					$valor = $array_post['txt-valor-'.$i];
					$modelo_merma_dep->setAttribute('merma_id', $model->id);
					$modelo_merma_dep->setAttribute('material', $material);
					$modelo_merma_dep->setAttribute('cantidad', $cantidad);
					$modelo_merma_dep->setAttribute('valor', $valor);
					$modelo_merma_dep->save();	
					
					$total_recuperado = $total_recuperado + ($cantidad * $valor);
					
					
					
				}

                $model->setAttribute('total',$total_recuperado);				
				$model->save();
			   
			   
		   }
			
		/*********************** Validar Imagen ****************/
			$images = UploadedFile::getInstances($model, 'image');
			//VarDumper::dump($images);
			
			foreach($images as $image){

				  if($image !== null)
				  {
					  $foto_merma = new FotoMerma();	
					  $ext = end((explode(".", $image->name)));
				      $name = date('Ymd').rand(1, 10000).''.$image->name;
				      $path = Yii::$app->params['uploadPath'] . $name;
				      $foto_merma->setAttribute('imagen',$shortPath. $name);
				      $foto_merma->setAttribute('merma_id',$model->id);
					  $image->saveAs($path);
					  $foto_merma->save();

				  }

		
			}

            $model = new Merma();
			return $this->render('create', [
                'model' => $model,
				'dependencias' => $dependencias,
				'areas' => $areas,
				'marcasUsuario' => $marcasUsuario,
				'distritosUsuario' => $distritosUsuario,
				'zonasUsuario' => $zonasUsuario,
				'merma' => 'active',
				'done' => '200',
            ]);
			
        } else {
				return $this->render('create', [
					'model' => $model,
					'dependencias' => $dependencias,
					'areas' => $areas,
					'marcasUsuario' => $marcasUsuario,
					'distritosUsuario' => $distritosUsuario,
					'merma' => 'active',
					'zonasUsuario' => $zonasUsuario,
					//'zonas' => $zonas,
				]);
        }
    }

    /**
     * Updates an existing Merma model.
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
     * Deletes an existing Merma model.
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
     * Finds the Merma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Merma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Merma::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
