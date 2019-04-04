<?php

namespace app\controllers;

use Yii;
use app\models\PrefacturaFija;
use app\models\ModeloPrefactura;
use app\models\PrefacturaDispositivo;
use app\models\Dia;
use app\models\Zona;
use app\models\Jornada;
use app\models\DetalleServicio;
use app\models\Empresa;
use app\models\CentroCosto;
use app\models\Usuario;
use app\models\Puesto;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;

class PrefacturaFijaController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'View', 'Cargar', 'Create', 'Update', 'Delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'View', 'Cargar', 'Create', 'Update', 'Delete'],
                        'roles'   => ['@'], //para usuarios logueados
                    ],
                ],  
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                   // 'delete' => ['GET'],
                    'update' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $zonas = Zona::find()->all();
        $dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
        $empresas = Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();
        $zonasUsuario = array();
        $marcasUsuario = array();
        $distritosUsuario = array();
        $empresasUsuario = array();
    
        $filas = array();
        
        if($usuario != null){
          $zonasUsuario = $usuario->zonas;      
          $marcasUsuario = $usuario->marcas;
          $distritosUsuario = $usuario->distritos;        
          $empresasUsuario = $usuario->empresas;
        }
        $llaves = array();
        $id_pendiente = '';
        $page=0;$rowsPerPage=20;
        if(isset($_POST['page'])) {
            if($_POST['page']!=0){
                $page = (isset($_POST['page']) ? $_POST['page'] : 1);
                $cur_page = $page;
                $page -= 1;
                $per_page = $rowsPerPage; // Per page records
                $previous_btn = true;
                $next_btn = true;
                $first_btn = true;
                $last_btn = true;
                $start = $page * $per_page;
            }else{
                $per_page = $rowsPerPage; // Per page records
                $start = $page * $per_page;
                $cur_page = 1;
                $previous_btn = true;
                $next_btn = true;
                $first_btn = true;
                $last_btn = true;
            }
        }else{
            $per_page = $rowsPerPage; // Per page records
            $start = $page * $per_page;
            $cur_page = 1;
            $previous_btn = true;
            $next_btn = true;
            $first_btn = true;
            $last_btn = true;
        }
        $rows = (new \yii\db\Query())
        ->select(['dp.id id', 'DATE(dp.created) fecha','dp.mes mes','dp.ano ano','dp.usuario usuario','cc.nombre dependencia','em.nombre empresa','dp.estado estado'])
        ->from('prefactura_fija dp, centro_costo cc, empresa em')
        ->where('dp.centro_costo_codigo=cc.codigo AND dp.empresa=em.nit');
        if(isset($_POST['desde'])){
            if($_POST['desde']!="" && $_POST['hasta']!=""){
                $rows->andWhere("DATE(dp.created) between '".$_POST['desde']."' AND '".$_POST['hasta']."'");
            }
        }
        if(isset($_POST['buscar'])){
            if (trim($_POST['buscar'])!='') {
                $buscar=trim($_POST['buscar']);
                $dependencia='';
                if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                    $dependencia=trim($_POST['dependencias2']);
                }
                $rows->andWhere("dp.mes like '%". $buscar."%' OR dp.ano like '%".$buscar."%' OR em.nombre like '%".$buscar."%' OR dp.usuario like '%".$buscar."%'");
                if($dependencia!=''){
                    $rows->andWhere("cc.nombre like '%".$dependencia."%'");
                }
            }else if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                $rows->andWhere("cc.nombre like '%".$_POST['dependencias2']."%'");
            }
        }
        $rowsCount= clone $rows;
        $ordenado='dp.id';
        if(isset($_POST['ordenado'])){
            switch ($_POST['ordenado']) {
                case "mes":
                    $ordenado='dp.mes';
                    break;
                case "ano":
                    $ordenado='dp.ano';
                    break;
                case "dependencia":
                    $ordenado='cc.nombre';
                    break;
                case "empresa":
                    $ordenado='em.nombre';
                    break;
                case "fecha":
                    $ordenado='dp.created';
                    break;
            }
        }
        if(isset($_POST['forma'])){
            if($_POST['forma']=='SORT_ASC'){
                $rows->orderBy([$ordenado => SORT_ASC]);
            }else{
                $rows->orderBy([$ordenado => SORT_DESC]);
            }
        }else{
            $rows->orderBy([$ordenado => SORT_DESC]);
        }
        if(!isset($_POST['excel'])){
            $rows->limit($rowsPerPage)->offset($start);
        }
        $command = $rows->createCommand();
        //echo $command->sql;exit();
        $prefacturas = $command->queryAll();
        if(isset($_POST['excel'])){
            \moonland\phpexcel\Excel::widget([
                'models' => $prefacturas,
                'mode' => 'export',
                'fileName' => 'listado de prefacturas', 
                'columns' => ['mes','ano','dependencia','empresa','estado'],
                'headers' => [
                    'mes' => 'MES',
                    'ano' => 'AÑO',
                    'dependencia' => 'DEPENDENCIA',
                    'empresa'=>'EMPRESA',
                    'estado'=>'ESTADO'
                ], 
            ]);
        }
        $modelcount = $rowsCount->count();
        $no_of_paginations = ceil($modelcount / $per_page);
        $res='';
        if($modelcount > $rowsPerPage){
            $res.=$this->renderPartial('_paginacion_partial', array(
                'cur_page' => $cur_page,
                'no_of_paginations' => $no_of_paginations,
                'first_btn' => $first_btn,
                'previous_btn' => $previous_btn,
                'next_btn' => $next_btn,
                'last_btn' => $last_btn,
                'modelcount' => $modelcount
            ), true);
        }
        $res.= $this->renderPartial('_partial', array(
            'prefacturas' => $prefacturas,
            'historico' => 'active', 'usuario' => $usuario,
            'modelcount' => $modelcount
                ), true);
        if(isset($_POST['page'])){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'respuesta' => $res,
                'query' => $command->sql,
            ];
        }else{
            return $this->render('index',
                ['partial' => $res, 
                'historico' => 'active',
                'zonas' => $zonas,
                'dependencias' => $dependencias,
                'empresas' => $empresas,
                'zonasUsuario' => $zonasUsuario,
                'marcasUsuario' => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,                
                'empresasUsuario' => $empresasUsuario,]);
        }
    }

    public function actionView($id){
        $dispositivos = PrefacturaDispositivo::find()->where('id_prefactura_fija='.$id)->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dispositivos' => $dispositivos,
        ]);
    }
	
    public function actionCreate(){
        $model = new PrefacturaFija();
		date_default_timezone_set ( 'America/Bogota');
        $fecha_actual = date('Y-m-d H:i:s');
		$dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();	
		$empresas = Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();
        $zonas = Zona::find()->all();
        Yii::$app->session->setTimeout(5400);				
		$usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
		$zonasUsuario = array();
		$marcasUsuario = array();
		$distritosUsuario = array();
		$empresasUsuario = array();
	
        $filas = array();
		
		if($usuario != null){
          $zonasUsuario = $usuario->zonas;		
          $marcasUsuario = $usuario->marcas;
          $distritosUsuario = $usuario->distritos;		  
		  $empresasUsuario = $usuario->empresas;
		}
        if ($model->load(Yii::$app->request->post())) {
            $model->setAttribute('usuario', Yii::$app->session['usuario-exito']);
			$model->setAttribute('created', $fecha_actual);
			$model->setAttribute('updated', $fecha_actual);
            $model->setAttribute('estado', 'abierto');
            //buscar la dependencia
            $dependencia = CentroCosto::findOne($model->centro_costo_codigo);
            $zona = Zona::findOne($model->regional);
            $model->setAttribute('ciudad', $dependencia->ciudad->nombre);
            $model->setAttribute('marca', $dependencia->marca->nombre);
            $model->setAttribute('empresa', $dependencia->empresa);
            $model->setAttribute('regional', $zona->nombre);

			$prefactura = PrefacturaFija::find()->where(['ano' => $model->ano,'mes' => $model->mes,'centro_costo_codigo' => $model->centro_costo_codigo])->one();
            $mensaje='';
			if($prefactura == null){
                //cargar configuracion dispositivo fijo
                $modelo_prefactura = ModeloPrefactura::find()->where("centro_costo_codigo='".$model->centro_costo_codigo."'")->all();
                if(count($modelo_prefactura)>0){
                    $model->save();
                    foreach ($modelo_prefactura as $mp) {
                        $pd = new PrefacturaDispositivo();
                        $pd->setAttribute('puesto_id', $mp->puesto_id);
                        $pd->setAttribute('detalle_servicio_id', $mp->detalle_servicio_id);
                        $pd->setAttribute('cantidad_servicios', $mp->cantidad_servicios);
                        $pd->setAttribute('horas', $mp->horas);
                        $pd->setAttribute('lunes', $mp->lunes);
                        $pd->setAttribute('martes', $mp->martes);
                        $pd->setAttribute('miercoles', $mp->miercoles);
                        $pd->setAttribute('jueves', $mp->jueves);
                        $pd->setAttribute('viernes', $mp->viernes);
                        $pd->setAttribute('sabado', $mp->sabado);
                        $pd->setAttribute('domingo', $mp->domingo);
                        $pd->setAttribute('festivo', $mp->festivo);
                        $pd->setAttribute('hora_inicio', $mp->hora_inicio);
                        $pd->setAttribute('hora_fin', $mp->hora_fin);
                        $pd->setAttribute('porcentaje', $mp->porcentaje);
                        $pd->setAttribute('ftes', $mp->ftes);
                        $pd->setAttribute('ftes_diurno', $mp->ftes_diurno);
                        $pd->setAttribute('ftes_nocturno', $mp->ftes_nocturno);
                        $pd->setAttribute('total_dias', $mp->total_dias);
                        $pd->setAttribute('valor_mes', $mp->valor_mes);
                        $pd->setAttribute('centro_costo_codigo', $mp->centro_costo_codigo);
                        $pd->setAttribute('id_prefactura_fija', $model->id);
                        $pd->setAttribute('tipo', 'fijo');
                        if(!$pd->save()){
                            print_r($pd->getErrors());exit();
                        }
                    }
                    return $this->redirect(['view', 'id' => $model->id ]);
                }else{
                    $mensaje='No se encontraron "DISPOSITIVOS FIJOS", Por favor, configure en la Dependencia los dispositivos fijos.';
                }
			}else{
                $mensaje='Ya se encuentra creada una Pre-factura en esta dependencia para este tiempo';
            }
			return $this->render('create', [
                'model' => $model,
                'zonas' => $zonas,
                'dependencias' => $dependencias,
                'empresas' => $empresas,
                'zonasUsuario' => $zonasUsuario,
                'marcasUsuario' => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,                
                'empresasUsuario' => $empresasUsuario,
                'mensaje' => $mensaje,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'zonas' => $zonas,
				'dependencias' => $dependencias,
				'empresas' => $empresas,
				'zonasUsuario' => $zonasUsuario,
				'marcasUsuario' => $marcasUsuario,
				'distritosUsuario' => $distritosUsuario,				
				'empresasUsuario' => $empresasUsuario,
            ]);
        }
    }
    public function actionUpdate(){
        $model = $this->findModel($_POST['id']);
        $model->setAttribute('estado','cerrado');
        $res='';
        if($model->save()){
            $res='true';
        }else{
            $res=print_r($model->getErrors());
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'respuesta' => $res,
        ];
    }
    public function actionDelete($id/*, $prefactura*/){

        //$prefactura_dispositivo = PrefacturaDispositivo::findOne($id);
        $prefactura_dispositivo = PrefacturaFija::findOne($id);

        if($prefactura_dispositivo != null){

            $prefactura_dispositivo->delete();

        }
       // return $this->redirect(['view', 'id' => $prefactura ]);
         return $this->redirect('index');
    }
    protected function findModel($id){
        if (($model = PrefacturaFija::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionCreateDispositivo($id)//variable
    {
        $this->layout = 'main_sin_menu';
        Yii::$app->session->setTimeout(5400);
        $array_post = Yii::$app->request->post();
        $model      = new PrefacturaDispositivo();
        date_default_timezone_set ( 'America/Bogota');
        $year = date('Y',time());
        $servicios  = DetalleServicio::find()->where("ano='".$year."'")->orderBy(['codigo' => SORT_ASC])->all();
        $puesto  = Puesto::find()->all();
        $jornada  = Jornada::find()->all();

        if (isset($array_post) && array_key_exists('hora_fin2', $array_post)) {
            $pf = PrefacturaFija::findOne($id);
            $cantidad = $array_post['PrefacturaDispositivo']['cantidad_servicios'];
            $detalle_servicio  = $array_post['PrefacturaDispositivo']['detalle_servicio_id'];
            //echo $array_post['PrefacturaDispositivo']['cantidad_servicios'];exit();
            //print_r($array_post);
            //echo "aqui".$cantidad;exit();
            if ($detalle_servicio != 0) {
                //guardar filas
                $prefactura_dispositivo = new PrefacturaDispositivo();
                $puesto = $array_post['PrefacturaDispositivo']['puesto_id'];
                $can_servicio = $array_post['PrefacturaDispositivo']['cantidad_servicios'];
                $jornada = $array_post['PrefacturaDispositivo']['horas'];
                $desde = $array_post['PrefacturaDispositivo']['hora_inicio'];
                $hasta = $array_post['hora_fin2'];
                $porcentaje = $array_post['PrefacturaDispositivo']['porcentaje'];
                $ftes = $array_post['ftes2'];
                $ftes_diurno = $array_post['ftes_diurno'];
                $ftes_nocturno = $array_post['ftes_nocturno'];
                $dias_totales = $array_post['PrefacturaDispositivo']['total_dias'];
                $precio = $array_post['valor_servicio2'];
                $tipo_servicio = $array_post['PrefacturaDispositivo']['tipo_servicio'];
                
                
                $prefactura_dispositivo->setAttribute('detalle_servicio_id', $detalle_servicio);
                $prefactura_dispositivo->setAttribute('puesto_id', $puesto);
                $prefactura_dispositivo->setAttribute('cantidad_servicios', $can_servicio);
                $prefactura_dispositivo->setAttribute('horas', $jornada);
                $prefactura_dispositivo->setAttribute('hora_inicio', $desde);
                $prefactura_dispositivo->setAttribute('hora_fin', $hasta);
                $prefactura_dispositivo->setAttribute('porcentaje', $porcentaje);
                $prefactura_dispositivo->setAttribute('ftes', $ftes);
                $prefactura_dispositivo->setAttribute('ftes_diurno', $ftes_diurno);
                $prefactura_dispositivo->setAttribute('ftes_nocturno', $ftes_nocturno);
                $prefactura_dispositivo->setAttribute('total_dias', $dias_totales);
                $prefactura_dispositivo->setAttribute('valor_mes', $precio);
                $prefactura_dispositivo->setAttribute('centro_costo_codigo', $pf->centro_costo_codigo);
                $prefactura_dispositivo->setAttribute('id_prefactura_fija', $id);
                $prefactura_dispositivo->setAttribute('tipo', 'variable');
                $prefactura_dispositivo->setAttribute('tipo_servicio', $tipo_servicio);
                if($prefactura_dispositivo->save()){
                    return $this->redirect(['view', 'id' => $id]);
                }else{
                    print_r($prefactura_dispositivo->getErrors());
                }
            }
        }else{
            return $this->render('create_dispositivo', [
                'codigo_dependencia' => $id,
                'servicios'          => $servicios,
                'puesto'          => $puesto,
                'modelo_prefactura'  => 'active',
                'model'              => $model,
                'jornada'              => $jornada,
            ]);
        }
    }
    public function actionImprimir($id){
        $prefactura  = PrefacturaFija::findOne($id);
        $dispositivos = PrefacturaDispositivo::find()->where('id_prefactura_fija='.$id)->all();
        $content = $this->renderPartial('_imprimir', array(
            'model' => $prefactura,
            'dispositivos' => $dispositivos
        ), true);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => 'table, td, th {border: 1px solid black;} .kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Prefactura'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['Prefactura'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render();
    }
}