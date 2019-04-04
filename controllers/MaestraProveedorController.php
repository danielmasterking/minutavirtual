<?php

namespace app\controllers;

use Yii;
use app\models\MaestraProveedor;
use app\models\Proveedor;
use app\models\Zona;
use app\models\Marca;
use app\models\MaestraMarca;
use app\models\MaestraZona;
use app\models\DetalleMaestra;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;
use yii\helpers;
use yii\helpers\Json;
use \yii\web\Response;
use yii\filters\AccessControl;

/**
 * MaestraProveedorController implements the CRUD actions for MaestraProveedor model.
 */
class MaestraProveedorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        	'access' => [
                'class' => AccessControl::className(),
                'only'  => ['Listado', 'index', 'View', 'DesactivarMaestra', 'Desactivar', 'Create', 'ActivarProducto', 'DesactivarProducto', 'Update', 
                			'Delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['Listado', 'index', 'View', 'DesactivarMaestra', 'Desactivar', 'Create', 'ActivarProducto', 'DesactivarProducto', 
                        			  'Update', 'Delete'],
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
	
	
    public function actionListado(){

        $out = [];
        $maestra = '3';
        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
              
                $maestra_id = $parents[0];
				
                $materiales = DetalleMaestra::find()->where(['maestra_proveedor_id' => $maestra_id])
                                              ->all(); 
                                             

                $data =  array();
				$defaultValue = '';

                foreach ($materiales as $key) {
                          
                  $data [] = array('id' => $key->material, 'name' => $key->material.'-'.$key->texto_breve);						  
                  $defaultValue =  $key->material;   
                }                         
                
                $value = (count($data) === 0) ? ['' => ''] : $data; 

                $out = $value; 
                
                echo Json::encode(['output'=> $out, 'selected'=> $defaultValue]);
                return;
            }


        }

        echo Json::encode(['output'=>'', 'selected'=>'']);

    }		

    /**
     * Lists all MaestraProveedor models.
     * @return mixed
     */
    public function actionIndex()
    {
        
		$maestras = MaestraProveedor::find()->orderBy(['proveedor_id' => SORT_ASC])->all();

        return $this->render('index', [
            'maestras' => $maestras,
			'maestra' => 'active', 
        ]);
    }

    /**
     * Displays a single MaestraProveedor model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        //ver contenido de maestra 
		$detalleMaestras = DetalleMaestra::find()->where(['maestra_proveedor_id' => $id])->orderBy(['texto_breve' => SORT_ASC])->all();
		
		return $this->render('view', [
            //'model' => $this->findModel($id),
			'productos' => $detalleMaestras,
			'maestra' => 'active',
			
        ]);
    }
	
	public function actionDesactivarMaestra($id){
		
		$productos = DetalleMaestra::find()->where(['maestra_proveedor_id' => $id,'estado' => 'A'])->all();
		$maestra = MaestraProveedor::findOne($id);
		foreach($productos as $key){
			
			
			$key->setAttribute('estado','N');
			$key->save();
			
		}
		
		if($maestra != null){
			
			$maestra->setAttribute('estado','D');
			$maestra->save();
		}

		
		return $this->redirect('index');
	}
	
	public function actionDesactivar($id){
		
		//conexión
		$primaryConnection = Yii::$app->db;
		
		
		$sql = "SELECT material AS MATERIAL,COUNT(*) AS CANTIDAD 
		          FROM detalle_maestra 
				  where maestra_proveedor_id = :maestra 
				  AND estado = 'A' 
				  group by material";
				  
		$docCompraActualSql = "SELECT  MAX(m.documento_compras) AS DOC_ACTUAL
								   FROM detalle_maestra m
									WHERE m.material = :material 
									and m.maestra_proveedor_id = :maestra 
									and m.estado = 'A';   
									";		  
		
		$desactivarProductoSql = "UPDATE detalle_maestra 
		                          SET estado = 'N' 
								  WHERE material = :material
								  AND   maestra_proveedor_id = :maestra
								  AND   estado = 'A'
								  AND   documento_compras != :documento";
		
		$command = $primaryConnection->createCommand($sql);	
		$docCommand = $primaryConnection->createCommand($docCompraActualSql);	
		$desactivarCommand = $primaryConnection->createCommand($desactivarProductoSql);	
		
		
		$maestraMarcaCommand = $primaryConnection->createCommand("SELECT marca_id 
															       FROM  maestra_marca
															        WHERE maestra_proveedor_id = :maestra
															     ");

		$maestraMarcaCommand = $primaryConnection->createCommand("SELECT zona_id 
															       FROM  maestra_zona
															        WHERE maestra_proveedor_id = :maestra
															     ");																 
		
		//productos repetidos para maestra de proveedor
		$productosRepetidos = $command->bindValue(':maestra',$id)->queryAll();
        

		foreach($productosRepetidos as $producto){
			
			//validar si cantidad es mayor a 1
			if($producto['CANTIDAD'] > 1){
				
				
				//producto repetido obtener documento de compra actual
                $codMaterial = $producto['MATERIAL'];
				
				$documentosCompra = $docCommand->bindValues([':material' => $codMaterial,':maestra' => $id])->queryAll();
				
				$documentoActual = '';
				
				if(count($documentosCompra) > 0){
					
				    $documentoActual = $documentosCompra[0]['DOC_ACTUAL'];

                    //Desactivar Productos de documentos antiguos.
                    $desactivarCommand->bindValues([':material' => $codMaterial,
					                                ':maestra' => $id,
													':documento' => $documentoActual])->execute();					
					
				}
				
			}
			
			
		}
		
		return $this->redirect('index');
		
	}

    /**
     * Creates a new MaestraProveedor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MaestraProveedor();
		$proveedores = Proveedor::find()->orderBy(['nombre' => SORT_ASC])->all();
		$marcas = Marca::find()->orderBy(['nombre' => SORT_ASC])->all();
		$zonas = Zona::find()->orderBy(['nombre' => SORT_ASC])->all();
	    Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
		$shortPath = 'uploads/';
		
		$array_post = Yii::$app->request->post();
		
		$fecha_documento = array_key_exists('fecha_documento', $array_post) ? $array_post['fecha_documento'] : '';
		$fecha_inicio_periodo = array_key_exists('fecha_inicio_periodo', $array_post) ? $array_post['fecha_inicio_periodo'] : '';
		$fecha_final_periodo = array_key_exists('fecha_final_periodo', $array_post) ? $array_post['fecha_final_periodo'] : '';
		$valor_total_maestra = array_key_exists('valor-total-maestra', $array_post) ? $array_post['valor-total-maestra'] : '';
		$valor_pendiente_por_gastar = array_key_exists('valor-pendiente-gastar', $array_post) ? $array_post['valor-pendiente-gastar'] : '';
		
		
		  $fecha_documento = strtotime('+1 day' , strtotime ( $fecha_documento ));
		  $fecha_documento = date('Y-m-d',$fecha_documento);
		  $fecha_inicio_periodo = strtotime('+1 day' , strtotime ( $fecha_inicio_periodo ));
		  $fecha_inicio_periodo = date('Y-m-d',$fecha_inicio_periodo);
		  $fecha_final_periodo = strtotime('+1 day' , strtotime ( $fecha_final_periodo ));
		  $fecha_final_periodo = date('Y-m-d',$fecha_final_periodo);
		  
		
				
		$primaryConnection = Yii::$app->db;
		
		$primaryCommand = $primaryConnection->createCommand("DELETE 
															 FROM maestra_zona
															 WHERE maestra_proveedor_id = :maestra
															 ");
															 
		$secondCommand = $primaryConnection->createCommand("DELETE 
															 FROM maestra_marca
															 WHERE maestra_proveedor_id = :maestra
															 ");
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			
			
			
			
            
			$file = UploadedFile::getInstance($model, 'file_upload');
			$id = $model->id;
		    if($file !== null)
		   {
			  			  
			  $path = Yii::$app->params['uploadPath'].$file->name;
			  $shortPath .= $file->name;
			  
			  $result = $file->saveAs($path);
              
               if($result){
				   
				   //leer archivo guardado
				   
				   try{
					   
					   $inputFileType = \PHPExcel_IOFactory::identify($shortPath);
					   $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
					   $objPHPExcel = $objReader->load($shortPath);
					   
					   
				   }catch(Exception $e){
					   
					   die("Error");
					   
				   }
				   
				   
				   $sheet = $objPHPExcel->getSheet(0);
				   $filaMayor = $sheet->getHighestRow();
				   $columnaMayor = $sheet->getHighestColumn();
				   
				   for($row = 1; $row <= $filaMayor; $row++){
					   
					   $rowData = $sheet->rangeToArray('A'.$row.':'.$columnaMayor.$row,NULL,TRUE,FALSE);
					   
					   if($row == 1){
						   
						   continue;
					   }
					   
					   $detalleMaestra = new DetalleMaestra();
					   $detalleMaestra->setAttribute('proveedor',''.$rowData[0][0].'');
					   $detalleMaestra->setAttribute('material',''.$rowData[0][2]);
					   $detalleMaestra->setAttribute('texto_breve',''.$rowData[0][3]);
					   $detalleMaestra->setAttribute('documento_compras',''.$rowData[0][4]);
					   $detalleMaestra->setAttribute('posicion',''.$rowData[0][5]);
					   $detalleMaestra->setAttribute('organizacion_compras',''.$rowData[0][6]);
					   $detalleMaestra->setAttribute('grupo_de_compras',''.$rowData[0][7]);
					   $detalleMaestra->setAttribute('marca',''.$rowData[0][15]);
					   $detalleMaestra->setAttribute('moneda',''.$rowData[0][10]);
					   $detalleMaestra->setAttribute('precio_neto',''.$rowData[0][8]);
					   $detalleMaestra->setAttribute('unidad_medida',''.$rowData[0][9]);
					   $detalleMaestra->setAttribute('valor_previsto','0');
					   $detalleMaestra->setAttribute('imputacion',''.$rowData[0][11]);
					   $detalleMaestra->setAttribute('distribucion',''.$rowData[0][12]);
					   $detalleMaestra->setAttribute('indicador_iva',''.$rowData[0][13]);
					   $detalleMaestra->setAttribute('codigo_activo_fijo',''.$rowData[0][14]);
					   $detalleMaestra->setAttribute('maestra_proveedor_id',$model->id);					   
					   $detalleMaestra->setAttribute('fecha_documento',$fecha_documento);
					   $detalleMaestra->setAttribute('fecha_inicio_periodo',$fecha_inicio_periodo);					   
					   $detalleMaestra->setAttribute('fecha_fin_periodo',$fecha_final_periodo);
					   $detalleMaestra->setAttribute('valor_total_maestra',$valor_total_maestra);
					   $detalleMaestra->setAttribute('valor_pendiente_por_gastar',$valor_pendiente_por_gastar);
					   $detalleMaestra->save();
					   
					 //  VarDumper::dump($rowData[0][14]);
					   //VarDumper::dump($detalleMaestra->getErrors());
					   
					   
				   }
			   
			   }			  
				
		   }

			return $this->redirect(['desactivar','id' => $id]);
			
			/*return $this->render('create', [
                'model' => $model,
				'proveedores' => $proveedores,
				'marcas' => $marcas,
				'zonas' => $zonas,
				'maestra' => 'active',
            ]);*/

		} else {
            return $this->render('create', [
                'model' => $model,
				'proveedores' => $proveedores,
				'marcas' => $marcas,
				'zonas' => $zonas,
				'maestra' => 'active',
            ]);
        }
    }
	
	
	public function actionActivarProducto($id_detalle_producto, $id_maestra){
	
		$pendiente = DetalleMaestra::findOne($id_detalle_producto);
		
		if($pendiente != null){
			
			// Estado A en estado (pedido, detallePedido) indica item aprobado
			$pendiente->setAttribute('estado', 'A');
			$pendiente->save();
		}
		
		
		
		return $this->redirect(['view', 'id' => $id_maestra ]);
			
		
	}

	public function actionDesactivarProducto($id_detalle_producto, $id_maestra){
	
		$pendiente = DetalleMaestra::findOne($id_detalle_producto);
		
		if($pendiente != null){
			
			// Estado A en estado (pedido, detallePedido) indica item aprobado
			$pendiente->setAttribute('estado', 'N');
			$pendiente->save();
		}
	
		return $this->redirect(['view', 'id' => $id_maestra ]);
			
		
	}	

    /**
     * Updates an existing MaestraProveedor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$proveedores = Proveedor::find()->orderBy(['nombre' => SORT_ASC])->all();
		$marcas = Marca::find()->orderBy(['nombre' => SORT_ASC])->all();
		$zonas = Zona::find()->orderBy(['nombre' => SORT_ASC])->all();
	    Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
		$shortPath = 'uploads/';
		
		$array_post = Yii::$app->request->post();
		
		$fecha_documento = array_key_exists('fecha_documento', $array_post) ? $array_post['fecha_documento'] : '';
		$fecha_inicio_periodo = array_key_exists('fecha_inicio_periodo', $array_post) ? $array_post['fecha_inicio_periodo'] : '';
		$fecha_final_periodo = array_key_exists('fecha_final_periodo', $array_post) ? $array_post['fecha_final_periodo'] : '';
		$valor_total_maestra = array_key_exists('valor-total-maestra', $array_post) ? $array_post['valor-total-maestra'] : '';
		$valor_pendiente_por_gastar = array_key_exists('valor-pendiente-gastar', $array_post) ? $array_post['valor-pendiente-gastar'] : '';
		
		  $fecha_documento = strtotime('+1 day' , strtotime ( $fecha_documento ));
		  $fecha_documento = date('Y-m-d',$fecha_documento);
		  $fecha_inicio_periodo = strtotime('+1 day' , strtotime ( $fecha_inicio_periodo ));
		  $fecha_inicio_periodo = date('Y-m-d',$fecha_inicio_periodo);
		  $fecha_final_periodo = strtotime('+1 day' , strtotime ( $fecha_final_periodo ));
		  $fecha_final_periodo = date('Y-m-d',$fecha_final_periodo);		
		
		
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$file = UploadedFile::getInstance($model, 'file_upload');
			
		    if($file !== null)
		   {
			  			  
			  $path = Yii::$app->params['uploadPath'].$file->name;
			  $shortPath .= $file->name;
			  
			  $result = $file->saveAs($path);
              
               if($result){
				   
				   //leer archivo guardado
				   
				   try{
					   
					   $inputFileType = \PHPExcel_IOFactory::identify($shortPath);
					   $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
					   $objPHPExcel = $objReader->load($shortPath);
					   
					   
				   }catch(Exception $e){
					   
					   die("Error");
					   
				   }
				   
				   
				   $sheet = $objPHPExcel->getSheet(0);
				   $filaMayor = $sheet->getHighestRow();
				   $columnaMayor = $sheet->getHighestColumn();
				   
				   for($row = 1; $row <= $filaMayor; $row++){
					   
					   $rowData = $sheet->rangeToArray('A'.$row.':'.$columnaMayor.$row,NULL,TRUE,FALSE);
					   
					   if($row == 1){
						   
						   continue;
					   }
					   
					   $detalleMaestra = new DetalleMaestra();
					   $detalleMaestra->setAttribute('proveedor',''.$rowData[0][0].'');
					   $detalleMaestra->setAttribute('material',''.$rowData[0][2]);
					   $detalleMaestra->setAttribute('texto_breve',''.$rowData[0][3]);
					   $detalleMaestra->setAttribute('documento_compras',''.$rowData[0][4]);
					   $detalleMaestra->setAttribute('posicion',''.$rowData[0][5]);
					   $detalleMaestra->setAttribute('organizacion_compras',''.$rowData[0][6]);
					   $detalleMaestra->setAttribute('grupo_de_compras',''.$rowData[0][7]);
					   $detalleMaestra->setAttribute('marca',''.$rowData[0][15]);
					   $detalleMaestra->setAttribute('moneda',''.$rowData[0][10]);
					   $detalleMaestra->setAttribute('precio_neto',''.$rowData[0][8]);
					   $detalleMaestra->setAttribute('unidad_medida',''.$rowData[0][9]);
					   $detalleMaestra->setAttribute('valor_previsto','0');
					   $detalleMaestra->setAttribute('imputacion',''.$rowData[0][11]);
					   $detalleMaestra->setAttribute('distribucion',''.$rowData[0][12]);
					   $detalleMaestra->setAttribute('indicador_iva',''.$rowData[0][13]);
					   $detalleMaestra->setAttribute('codigo_activo_fijo',''.$rowData[0][14]);
					   $detalleMaestra->setAttribute('maestra_proveedor_id',$model->id);					   
					   $detalleMaestra->setAttribute('fecha_documento',$fecha_documento);
					   $detalleMaestra->setAttribute('fecha_inicio_periodo',$fecha_inicio_periodo);					   
					   $detalleMaestra->setAttribute('fecha_fin_periodo',$fecha_final_periodo);
					   $detalleMaestra->setAttribute('valor_total_maestra',$valor_total_maestra);
					   $detalleMaestra->setAttribute('valor_pendiente_por_gastar',$valor_pendiente_por_gastar);
					   $detalleMaestra->save();
					   
				   }
			   
			   }			  
				
		   }

			return $this->redirect(['desactivar','id' => $id]);
			
        } else {
            return $this->render('update', [
                'model' => $model,
				'proveedores' => $proveedores,
				'marcas' => $marcas,
				'zonas' => $zonas,
				'maestra' => 'active',
				'actualizar' => 'S',
            ]);
        }
    }

    /**
     * Deletes an existing MaestraProveedor model.
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
     * Finds the MaestraProveedor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaestraProveedor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MaestraProveedor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
