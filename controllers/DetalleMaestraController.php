<?php

namespace app\controllers;

use Yii;
use app\models\DetalleMaestra;
use app\models\Usuario;
use app\models\CentroCosto;
use app\models\MaestraProveedor;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DetalleMaestraController implements the CRUD actions for DetalleMaestra model.
 */
class DetalleMaestraController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'Create', 'Update', 'delete', 'productos'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'Create', 'Update', 'delete', 'productos'],
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
     * Lists all DetalleMaestra models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => DetalleMaestra::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DetalleMaestra model.
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
     * Creates a new DetalleMaestra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DetalleMaestra();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DetalleMaestra model.
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
     * Deletes an existing DetalleMaestra model.
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
     * Finds the DetalleMaestra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DetalleMaestra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DetalleMaestra::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionProductos(){
        $rowsPerPage=500;
        $page=0;
        if(isset($_POST['page'])) {
            if($_POST['page']!=0){
                $page = (isset($_POST['page']) ? $_POST['page'] : 1);
                $page -= 1;
                $per_page = $rowsPerPage; // Per page records
                $start = $page * $per_page;
            }else{
                $per_page = $rowsPerPage; // Per page records
                $start = $page * $per_page;
            }
        }else{
            $per_page = $rowsPerPage; // Per page records
            $start = $page * $per_page;
        }
       /* $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $zonasUsuario = $usuario->zonas;*/
		
		$dependencia = CentroCosto::findOne($_POST['codigo_dependencia']);
        $ciudad_dependencia = $dependencia->ciudad;
		$zonasCiudad = $ciudad_dependencia->ciudadZonas;
		
        $zonas_ids = array();
		//buscar las zonas permitidas para el usuario
        /*foreach($zonasUsuario as $zonaO){
            $zonas_ids [] = $zonaO->zona->id;
        }*/
        $cadenaZona='';
		foreach($zonasCiudad as $zonaO){
            $zonas_ids [] = $zonaO->zona->id;
            $cadenaZona.=$zonaO->zona->id.',';
        }
        //buscar en la maestra_proveedor que regionales tienen permitidas
        $maestra_proveedor_aux = MaestraProveedor::find();
        $maestra_where = '';
        $tam=count($zonas_ids);
        for ($i=0; $i < $tam; $i++) {
            if($i==0){
                $maestra_where.= "zona_id=".$zonas_ids[$i]." OR zona_id_2=".$zonas_ids[$i]." OR zona_id_3=".$zonas_ids[$i]." OR zona_id_4=".$zonas_ids[$i]." OR zona_id_5=".$zonas_ids[$i]." OR zona_id_6=".$zonas_ids[$i]." OR zona_id_7=".$zonas_ids[$i]." OR zona_id_8=".$zonas_ids[$i]." OR zona_id_9=".$zonas_ids[$i]." OR zona_id_10=".$zonas_ids[$i];
            }else{
                $maestra_where.= " OR zona_id=".$zonas_ids[$i]." OR zona_id_2=".$zonas_ids[$i]." OR zona_id_3=".$zonas_ids[$i]." OR zona_id_4=".$zonas_ids[$i]." OR zona_id_5=".$zonas_ids[$i]." OR zona_id_6=".$zonas_ids[$i]." OR zona_id_7=".$zonas_ids[$i]." OR zona_id_8=".$zonas_ids[$i]." OR zona_id_9=".$zonas_ids[$i]." OR zona_id_10=".$zonas_ids[$i];
            }
        }
        $maestra_proveedor_aux->where($maestra_where);
        $maestra_proveedor = $maestra_proveedor_aux->all();
        //filtro por area(Seguridad, Riesgos...)
        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $area = $usuario->area;//la elegida
        $ambas = $usuario->ambas_areas;//seguridad y riesgos
        $cadena_area="";
        if($area=='Seguridad'){
            if($ambas=='S'){
                $cadena_area= "AND (distribucion='Seguridad' OR distribucion='Riesgos')";
            }else{
                $cadena_area= "AND distribucion='Seguridad'";
            }
        }else if($area=='Riesgos'){
            if($ambas=='S'){
                $cadena_area= "AND (distribucion='Seguridad' OR distribucion='Riesgos')";
            }else{
                $cadena_area= "AND distribucion='Riesgos'";
            }
        }else if($area=='Administracion'){
            if($ambas=='S'){
                $cadena_area= "AND (distribucion='Seguridad' OR distribucion='Riesgos' OR distribucion='Administracion')";
            }else{
                $cadena_area= "AND distribucion='Administracion'";
            }
        }

        $productos = DetalleMaestra::find();
       //$productos->where(['estado' => 'A']);
        $productos_aux = DetalleMaestra::find();
        //$productos_aux->where(['estado' => 'A']);
		$cadena_or = '';
		$cont = 0;
		
		foreach ($maestra_proveedor as $mprov) {
		    $cadena_or .= ($cont == 0) ? '(maestra_proveedor_id = '.$mprov->id : ' OR maestra_proveedor_id = '.$mprov->id; 
			/*$productos->orWhere(['maestra_proveedor_id'=>$mprov->id]);
            $productos_aux->orWhere(['maestra_proveedor_id'=>$mprov->id]);*/
			$cont++;
        }
		
		$cadena_or .= ") AND estado = 'A' ".$cadena_area;
		$productos->where($cadena_or);
        $productos_aux->where($cadena_or);
		
        $count = $productos_aux->count();
        $productos2=$productos->orderBy(['texto_breve' => SORT_ASC])->limit($rowsPerPage)->offset($start)->all();
        
		$data_productos = array();
		foreach ($productos2 as $value) {
			if($value->material == '1038687'){
			  $data_productos [] = $value;	
			}
			
		}		
         
	    $resultado = $this->renderPartial('_html', ['productos'=>$productos2]);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'count' => $count,
            'resultado' => $resultado,
			'debug' => $data_productos ,
            'contprov' => count($productos2),
            'query' => $productos->createCommand()->getRawSql(),
            'maestra_proveedor' => $maestra_proveedor_aux->createCommand()->getRawSql(),
            'cadenaZona' => $cadenaZona,
        ];
    }
}
