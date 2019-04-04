<?php
namespace app\controllers;

use Yii;
use app\models\CentroCosto;
use app\models\Usuario;
use app\models\Proyectos;
use app\models\ProyectosPresupuesto;
use app\models\ProyectoPedidos;
use app\models\ProyectoPedidoEspecial;
use app\models\Pedido;
use app\models\DetallePedido;
use app\models\DetallePedidoEspecial;
use app\models\ProyectoArchivo;
use app\models\UsuarioEmpresa;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use  yii\helpers\Url;
use yii\helpers\ArrayHelper;

class ProyectosController extends Controller{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','create','update','delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','create','update','delete'],
                        'roles' => ['@'],//para usuarios logueados
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $page=0;$rowsPerPage=20;
        $mensaje='';
        if(isset($_GET['mensaje'])){
            $mensaje=$_GET['mensaje'];
        }
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

        $permisos = array();
        if( isset(Yii::$app->session['permisos-exito']) ){
            $permisos = Yii::$app->session['permisos-exito'];
        }

        if(!in_array("administrador", $permisos)){
        $query = (new \yii\db\Query())
        ->select('pr.id id, '.
            "(SELECT COUNT(pp.id) FROM proyecto_pedidos pp WHERE pr.id=pp.proyecto_id AND pp.tipo_presupuesto='seguridad') count_normal_seguridad,".
            "(SELECT COUNT(pp.id) FROM proyecto_pedidos pp WHERE pr.id=pp.proyecto_id AND pp.tipo_presupuesto='riesgo') count_normal_riesgo,".
            "(SELECT COUNT(pp.id) FROM proyecto_pedido_especial pp WHERE pr.id=pp.proyecto_id AND pp.tipo_presupuesto='seguridad') count_especial_seguridad,".
            "(SELECT COUNT(pp.id) FROM proyecto_pedido_especial pp WHERE pr.id=pp.proyecto_id AND pp.tipo_presupuesto='riesgo') count_especial_riesgo,".
            'DATE(pr.fecha_finalizacion) fecha_finalizacion, '.
            'pr.nombre nombre, '.
            'pr.ceco ceco, '.
            'cc.nombre dependencia, '.
            'pr.solicitante solicitante, '.
            'pr.orden_interna_gasto orden_interna_gasto, '.
            'pr.orden_interna_activo orden_interna_activo, '.
            'pr.presupuesto_total presupuesto_total, '.
            'pr.presupuesto_seguridad presupuesto_seguridad, '.
            'pr.presupuesto_riesgo presupuesto_riesgo, '.
            'pr.presupuesto_activo presupuesto_activo, '.
            'pr.presupuesto_gasto presupuesto_gasto, '.
            'pr.suma_total suma_total, '.
            'pr.suma_seguridad suma_seguridad, '.
            'pr.suma_riesgo suma_riesgo, '.
            'pr.suma_activo suma_activo,'.
            'pr.suma_gasto suma_gasto,'.
            'pr.estado estado,'.
            'pr.iva iva,'.
            'c.nombre ciudad,'.
            'm.nombre marca'

            )
        ->from('proyectos pr, centro_costo cc,ciudad c,ciudad_zona cz,usuario_zona uz,marca m,usuario_marca um')
        ->where('pr.ceco=cc.codigo')
        ->andWhere('cc.ciudad_codigo_dane=c.codigo_dane')
        ->andWhere('cc.ciudad_codigo_dane=c.codigo_dane')
        ->andWhere('c.codigo_dane=cz.ciudad_codigo_dane')
        ->andWhere('cz.zona_id=uz.zona_id')
        ->andWhere('cc.marca_id=m.id')
        ->andWhere('m.id=um.marca_id')
        ->andWhere("uz.usuario='".Yii::$app->session['usuario-exito']."'")
        ->andWhere("um.usuario='".Yii::$app->session['usuario-exito']."'");
        }else{
            $query = (new \yii\db\Query())
        ->select('pr.id id, '.
            "(SELECT COUNT(pp.id) FROM proyecto_pedidos pp WHERE pr.id=pp.proyecto_id AND pp.tipo_presupuesto='seguridad') count_normal_seguridad,".
            "(SELECT COUNT(pp.id) FROM proyecto_pedidos pp WHERE pr.id=pp.proyecto_id AND pp.tipo_presupuesto='riesgo') count_normal_riesgo,".
            "(SELECT COUNT(pp.id) FROM proyecto_pedido_especial pp WHERE pr.id=pp.proyecto_id AND pp.tipo_presupuesto='seguridad') count_especial_seguridad,".
            "(SELECT COUNT(pp.id) FROM proyecto_pedido_especial pp WHERE pr.id=pp.proyecto_id AND pp.tipo_presupuesto='riesgo') count_especial_riesgo,".
            'DATE(pr.fecha_finalizacion) fecha_finalizacion, '.
            'pr.nombre nombre, '.
            'pr.ceco ceco, '.
            'cc.nombre dependencia, '.
            'pr.solicitante solicitante, '.
            'pr.orden_interna_gasto orden_interna_gasto, '.
            'pr.orden_interna_activo orden_interna_activo, '.
            'pr.presupuesto_total presupuesto_total, '.
            'pr.presupuesto_seguridad presupuesto_seguridad, '.
            'pr.presupuesto_riesgo presupuesto_riesgo, '.
            'pr.presupuesto_activo presupuesto_activo, '.
            'pr.presupuesto_gasto presupuesto_gasto, '.
            'pr.suma_total suma_total, '.
            'pr.suma_seguridad suma_seguridad, '.
            'pr.suma_riesgo suma_riesgo, '.
            'pr.suma_activo suma_activo,'.
            'pr.suma_gasto suma_gasto,'.
            'pr.estado estado,'.
            'pr.iva iva'
            )
        ->from('proyectos pr, centro_costo cc')
        ->where('pr.ceco=cc.codigo');
        }
        //->andWhere("uz.zona_id=cz.zona_id")
        //->andWhere("cz.ciudad_codigo_dane=cc.ciudad_codigo_dane")
        //->andWhere("uz.usuario=cc.ciudad_codigo_dane")
        //->andWhere("uz.usuario='".Yii::$app->session['usuario-exito']."'")
        

        if(isset($_POST['desde'])){
            if($_POST['desde']!="" && $_POST['hasta']!=""){
                $query ->andWhere("DATE(pr.fecha_finalizacion) between '".$_POST['desde']."' AND '".$_POST['hasta']."'");
            }
        }
        if(isset($_POST['buscar'])){
            if (trim($_POST['buscar'])!='') {
                $buscar=trim($_POST['buscar']);
                $dependencia='';
                if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                    $dependencia=trim($_POST['dependencias2']);
                }
                $query->andWhere("pr.nombre like '%". $buscar."%'");
                if($dependencia!=''){
                    $query->andWhere("cc.codigo like '%".$dependencia."%'");
                }
            }else if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                $query->andWhere("cc.codigo like '%".$_POST['dependencias2']."%'");
            }
        }
        $rowsCount= clone $query ;
        $ordenado='pr.fecha_finalizacion';
        if(isset($_POST['ordenado'])){
            switch ($_POST['ordenado']) {
                case "fecha_finalizacion":
                    $ordenado='pr.fecha_finalizacion';
                    break;
                case "nombre":
                    $ordenado='pr.nombre';
                    break;
                case "dependencia":
                    $ordenado='cc.nombre';
                    break;
            }
        }
        if(isset($_POST['forma'])){
            if($_POST['forma']=='SORT_DESC'){
                $query->orderBy([$ordenado => SORT_DESC]);
            }else{
                $query->orderBy([$ordenado => SORT_ASC]);
            }
        }else{
            $query ->orderBy([$ordenado => SORT_ASC]);
        }
        if(!isset($_POST['excel'])){
            $query ->limit($rowsPerPage)->offset($start);
        }
        $command = $query->createCommand();
        //echo $command->sql;exit();
        $model = $command->queryAll();
        if(isset($_POST['excel'])){
            \moonland\phpexcel\Excel::widget([
                'models' => $model,
                'mode' => 'export',
                'columns' => ['nombre','dependencia','presupuesto_total','presupuesto_seguridad','presupuesto_riesgo','presupuesto_activo','presupuesto_gasto','fecha_finalizacion'],
                'headers' => [
                    'nombre' => 'NOMBRE',
                    'dependencia' => 'DEPENDENCIA',
                    'presupuesto_total' => 'PRESUPUESTO TOTAL',
                    'presupuesto_seguridad' => 'PRESUPUESTO SEGURIDAD',
                    'presupuesto_riesgo' => 'PRESUPUESTO RIESGO',
                    'presupuesto_activo' => 'PRESUPUESTO ACTIVO',
                    'presupuesto_gasto' => 'PRESUPUESTO GASTO',
                    'fecha_finalizacion' => 'FECHA FINALIZACION'
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
        //echo $command->sql;exit();
        $res.= $this->renderPartial('_proyectos_partial', array(
            'model' => $model,
                ), true);
        if(isset($_POST['page'])){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'respuesta' => $res,
                'query' => $command->sql,
            ];
        }else{
            $usuario          = Usuario::findOne(Yii::$app->session['usuario-exito']);
            $zonasUsuario     = array();
            $marcasUsuario    = array();
            $distritosUsuario = array();
            if ($usuario != null) {
                $zonasUsuario     = $usuario->zonas;
                $marcasUsuario    = $usuario->marcas;
                $distritosUsuario = $usuario->distritos;
            }
            //D= en desarrollo
            $dependencias     = CentroCosto::find()->where("estado='D'")->orderBy(['nombre' => SORT_ASC])->all();
            return $this->render('index', [
                'respuesta' => $res,
                'dependencias'     => $dependencias,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'zonasUsuario'     => $zonasUsuario,
                'mensaje'     => $mensaje,
            ]);
        }
    }
    public function actionView($id){
        $presupuestos = ProyectosPresupuesto::find()->where('fk_proyectos='.$id)->all();
        $proyecto_archivo = new ProyectoArchivo();

        $usuario_empresa=UsuarioEmpresa::find()->where('usuario="'.Yii::$app->session['usuario-exito'].'"')->all();
        $list_empresas=ArrayHelper::map($usuario_empresa,'nit','empresa.nombre');



        return $this->render('view', [
            'model' => $this->findModel($id),
            'presupuestos' => $presupuestos,
            'empresas'=>$list_empresas,
            'proyecto_archivo'=>$proyecto_archivo
        ]);
    }
    public function actionCreate(){
        $model = new Proyectos();
        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set('America/Bogota');
            $fecha = date('Y-m-d H:i:s',time());
            $model->setAttribute('presupuesto_seguridad', 0);
            $model->setAttribute('presupuesto_riesgo', 0);
            $model->setAttribute('presupuesto_activo', 0);
            $model->setAttribute('presupuesto_gasto', 0);
            $model->setAttribute('presupuesto_total', 0);
            $model->setAttribute('orden_interna_gasto', '');
            $model->setAttribute('orden_interna_activo', '');
            $model->setAttribute('nombre', '');//no se utiliza
            $model->setAttribute('solicitante', Yii::$app->session['usuario-exito']);
            $model->setAttribute('created_on', $fecha);
            
            if($model->save()){
                return $this->redirect('index');
            }else{
                print_r($model->getErrors());
            }
        } else {
            $usuario          = Usuario::findOne(Yii::$app->session['usuario-exito']);
            $zonasUsuario     = array();
            $marcasUsuario    = array();
            $distritosUsuario = array();
            if ($usuario != null) {
                $zonasUsuario     = $usuario->zonas;
                $marcasUsuario    = $usuario->marcas;
                $distritosUsuario = $usuario->distritos;
            }
            //D= en desarrollo
            $dependencias     = CentroCosto::find()->where("estado='D'")->orderBy(['nombre' => SORT_ASC])->all();
            $presupuestos     = Proyectos::find()->all();
            $bandera=true;
            $dep_desarrollo=array();
            foreach ($dependencias as $dep) {
                foreach ($presupuestos as $pres) {
                    if($pres->ceco==$dep->codigo){
                        $bandera=false;break;
                    }else{
                        $bandera=true;
                    }
                }
                if($bandera){$dep_desarrollo[]=$dep;}
            }
            return $this->render('create', [
                'model' => $model,
                'dependencias'     => $dep_desarrollo,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'zonasUsuario'     => $zonasUsuario,
            ]);
        }
    }
    public function actionUpdate($id){
        $model = $this->findModel($id);
        //if($model->estado=='ABIERTO'){
            $array_post = Yii::$app->request->post();
            // echo "<pre>";
            // print_r($array_post);
            // echo "</pre>";
            //if (isset($array_post['Proyectos']['presupuesto_seguridad'])) {
            if (isset($array_post['Proyectos']['presupuesto_activo'])) {
                //print_r(Yii::$app->request->post());exit();
                date_default_timezone_set('America/Bogota');
                $fecha = date('Y-m-d H:i:s',time());
                $model->setAttribute('presupuesto_activo', 
                    $model->presupuesto_activo+$array_post['Proyectos']['presupuesto_activo']
                );
                //echo $model->presupuesto_riesgo;exit();
                $model->setAttribute('presupuesto_gasto', 
                    $model->presupuesto_gasto+$array_post['Proyectos']['presupuesto_gasto']
                );
                //$model->setAttribute('presupuesto_activo',0);
                //$model->setAttribute('presupuesto_gasto', 0);
                $model->setAttribute('presupuesto_total', 
                    // $model->presupuesto_seguridad+
                    // $model->presupuesto_riesgo
                    $model->presupuesto_activo+
                     $model->presupuesto_gasto
                );
                $model->setAttribute('modificado_por', Yii::$app->session['usuario-exito']);
                $model->setAttribute('modified_in', $fecha);
                if ($model->save()) {
                    $model_preps = new ProyectosPresupuesto();
                    $model_preps->setAttribute('fk_proyectos', $id);
                    // $model_preps->setAttribute('presupuesto_seguridad', $array_post['Proyectos']['presupuesto_seguridad']);
                    // $model_preps->setAttribute('presupuesto_riesgo', $array_post['Proyectos']['presupuesto_riesgo']);
                    $model_preps->setAttribute('presupuesto_activo', $array_post['Proyectos']['presupuesto_activo']);
                    $model_preps->setAttribute('presupuesto_gasto', $array_post['Proyectos']['presupuesto_gasto']);
                    $model_preps->setAttribute('created_on', $fecha);
                    if($model_preps->save()){
                        return $this->redirect('index');
                    }else{
                        print_r($model_preps->getErrors());
                    }
                }else{
                    print_r($model->getErrors());
                }
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        /*}else{
            return $this->redirect(['index', 
                'mensaje' => 'El proyecto se encuentra en estado '.$model->estado,
            ]);
        }*/
        
    }
    public function actionDelete($id){
        $model=$this->findModel($id);
        try {
            if($model->delete()){
               return $this->redirect(['index']);
            }
        }catch (\Exception $e) {
            return $this->redirect(['index', 
                'mensaje' => 'No se pudo Eliminar el Presupuesto para '.$model->cecoo->nombre.', Si existen Pedidos Elimine primero los pedidos.',
            ]);
        }
    }
    protected function findModel($id){
        if (($model = Proyectos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionPedidosCreate($id="0",$ceco="0"){
        $presupuesto = $this->findModel($id);
        if($presupuesto->estado=='ABIERTO'){
            $array_post = Yii::$app->request->post();
            if (isset($array_post['cantidad-productos'])) {
                $cantidad    = array_key_exists('cantidad-productos', $array_post) ? $array_post['cantidad-productos'] : 0;
                $tipo_pedido = array_key_exists('tipo-pedido', $array_post) ? $array_post['tipo-pedido'] : '';
                //existen productos solicitados
                if ($cantidad > 0) {
                    $tipo = 'S';
                    if ($tipo_pedido == 'on') {
                        $tipo = 'N';
                    }
                    $proyecto = $this->findModel($array_post['pedido']);
                    //guardar productos solicitados
                    for ($i = 1; $i <= $cantidad; $i++) {
                        $model = new ProyectoPedidos();
                        $prod = array_key_exists('sel-produ-' . $i, $array_post) ? $array_post['sel-produ-' . $i] : 0;
                        if ($prod != 0) {
                            $cantidad_prod = $array_post['txt-cant-' . $i];
                            $obs_prod      = $array_post['txt-comentario-' . $i];
                            $precio_neto   = $array_post['price-' . $i];
                            $model->setAttribute('detalle_maestra_id', $prod);
                            $model->setAttribute('proyecto_id', $proyecto->id);
                            $model->setAttribute('estado_id', 1);
                            $model->setAttribute('cantidad', $cantidad_prod);
                            $model->setAttribute('precio_neto', $precio_neto);
                            $model->setAttribute('observaciones', $obs_prod);
                            $model->setAttribute('cebe', $proyecto->cecoo->cebe);
                            $model->setAttribute('tipo_presupuesto', $array_post['tipo_presupuesto']);
                            $model->setAttribute('solicitante', Yii::$app->session['usuario-exito']);
                            date_default_timezone_set('America/Bogota');
                            $fecha_hora = date("Y-m-d H:i:s");
                            $model->setAttribute('created_on', $fecha_hora);
                            //validar para repetido. buscar en la tabla por detalle_maestra_id, cantidad y dependencia hace 182 dias(6 meses)
                            $sql = "SELECT * FROM proyecto_pedidos WHERE created_on BETWEEN DATE_SUB('".$fecha_hora."', INTERVAL 182 DAY) AND '".$fecha_hora."' AND detalle_maestra_id=".$prod." AND cantidad=".$cantidad_prod.' ORDER BY created_on LIMIT 1';
                            $repetido = ProyectoPedidos::findBySql($sql);
                            $mrepetido = $repetido->count();
                            //echo $repetido->createCommand()->getRawSql();exit();
                            if($mrepetido>0){
                                $model->setAttribute('repetido', 'SI');
                            }
                            if($model->save()){
                                
                            }else{
                                print_r($model->getErrors());
                            }
                        }
                    }
                    return $this->redirect('index');
                }
            } else {
                return $this->render('pedidos/create_pedido', [
                    'ceco' => $ceco,
                    'id' => $id,
                ]);
            }
        }else{
            return $this->redirect(['index', 
                'mensaje' => 'El proyecto se encuentra en estado '.$presupuesto->estado,
            ]);
        }
        
    }
    public function actionPedidosCreateEspecial($id="0",$ceco="0"){
        $presupuesto = $this->findModel($id);
        if($presupuesto->estado=='ABIERTO'){
            $array_post = Yii::$app->request->post();
            if (isset($array_post['cantidad-productos'])) {
                $cantidad    = array_key_exists('cantidad-productos', $array_post) ? $array_post['cantidad-productos'] : 0;
                $file = UploadedFile::getInstanceByName('file');
                $proyecto = $this->findModel($array_post['pedido']);
                $model = new ProyectoPedidoEspecial();
                if ($cantidad > 0) {
                    $filename='';
                    if ($file !== null) {
                        $shortPath = 'uploads/proyectos/';
                        $ext            = end((explode(".", $file->name)));
                        $name           = date('Ymd') . rand(1, 10000) . '' . $file->name;
                        $path           = Yii::$app->basePath . '/web/uploads/proyectos/' . $name;
                        $filename = $shortPath . $name;
                        $file->saveAs($path);
                    }
                    //guardar productos solicitados
                    for ($i = 1; $i <= $cantidad; $i++) {
                        $prod = array_key_exists('sel-produ-' . $i, $array_post) ? $array_post['sel-produ-' . $i] : 0;
                        if ($prod != 0) {
                            $cantidad_prod = $array_post['txt-cant-' . $i];
                            $obs_prod      = $array_post['txt-prod-' . $i];
                            $precio_neto   = $array_post['price-' . $i];
                            $precio='';
                            if($array_post['txt-precio-' . $i]!=''){
                                $precio        = str_replace(".", "", $array_post['txt-precio-' . $i]);
                            }else{
                                $precio        = $array_post['txt-precio-' . $i];
                            }
                            $proveedor     = $array_post['txt-proveedor-' . $i];
                            $model->setAttribute('maestra_especial_id', $prod);
                            $model->setAttribute('proyecto_id', $proyecto->id);
                            $model->setAttribute('estado_id', 1);
                            $model->setAttribute('cantidad', $cantidad_prod);
                            $model->setAttribute('producto_sugerido', $obs_prod);
                            $model->setAttribute('precio_sugerido', $precio);
                            $model->setAttribute('precio_neto', $precio_neto);
                            $model->setAttribute('proveedor_sugerido', $proveedor);
                            $model->setAttribute('cebe', $proyecto->cecoo->cebe);
                            $model->setAttribute('tipo_presupuesto', $array_post['tipo_presupuesto']);
                            $model->setAttribute('archivo', $filename);
                            $model->setAttribute('solicitante', Yii::$app->session['usuario-exito']);
                            date_default_timezone_set('America/Bogota');
                            $fecha_hora = date("Y-m-d H:i:s");
                            $model->setAttribute('created_on', $fecha_hora);
                            //validar para repetido. buscar en la tabla por detalle_maestra_id, cantidad y dependencia hace 182 dias(6 meses)
                            $stringPrecio='';
                            if($precio>0){
                                $stringPrecio=' AND precio_sugerido='.$precio;
                            }
                            $sql = "SELECT * FROM proyecto_pedido_especial WHERE created_on BETWEEN DATE_SUB('".$fecha_hora."', INTERVAL 182 DAY) AND '".$fecha_hora."' AND maestra_especial_id=".$prod." AND cantidad=".$cantidad_prod.$stringPrecio.' ORDER BY created_on LIMIT 1';
                            $repetido = ProyectoPedidoEspecial::findBySql($sql);
                            $mrepetido = $repetido->count();
                            //echo $repetido->createCommand()->getRawSql();exit();
                            if($mrepetido>0){
                                $model->setAttribute('repetido', 'SI');
                            }
                            if($model->save()){
                                $model = new ProyectoPedidoEspecial();
                            }else{
                                print_r($model->getErrors());
                            }
                        }
                    }
                }
                return $this->redirect('index');
            } else {
                return $this->render('pedidos/create_pedido_especial', [
                    'ceco' => $ceco,
                    'id' => $id,
                ]);
            }
        }else{
            return $this->redirect(['index', 
                'mensaje' => 'El proyecto se encuentra en estado '.$presupuesto->estado,
            ]);
        }
    }
    public function actionPedidosNormales($estado=1){
        $array_post = Yii::$app->request->post();
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
        }
        $rows = (new \yii\db\Query())
        ->select('pp.gasto_activo gasto_activo, pp.precio_neto precio_neto, pp.id id, dm.texto_breve material, pr.nombre proveedor, pp.cantidad cantidad, pp.solicitante solicitante, dm.material codigo, DATE(pp.created_on) fecha, pp.repetido repetido, pp.tipo_presupuesto tipo_presupuesto, pp.motivo_rechazo motivo_rechazo')
        ->from('proyecto_pedidos pp, proyectos p, detalle_maestra dm, proyecto_estado_pedidos pe, proveedor pr, maestra_proveedor mp')
        ->where('pp.proyecto_id='.$array_post['proyecto'].' AND p.id=pp.proyecto_id AND pp.detalle_maestra_id=dm.id AND pp.estado_id=pe.id AND dm.maestra_proveedor_id=mp.id AND pr.id=mp.proveedor_id AND pp.estado_id='.$estado);
        // quite esto dm.proveedor=pr.codigo AND ** 5 de julio 2017
        if(isset($_POST['desde'])){
            if($_POST['desde']!="" && $_POST['hasta']!=""){
                $rows->andWhere("DATE(pp.created_on) between '".$_POST['desde']."' AND '".$_POST['hasta']."'");
            }
        }
        if(isset($_POST['buscar'])){
            if (trim($_POST['buscar'])!='') {
                $buscar=trim($_POST['buscar']);
                $rows->andWhere("pp.created_on like '%". $buscar."%' OR dm.texto_breve like '%".$buscar."%' OR pp.cantidad like '%".$buscar."%' OR pp.solicitante like '%".$buscar."%'");
            }
        }
        $rowsCount= clone $rows;
        $ordenado='dm.texto_breve';
        if(isset($_POST['ordenado'])){
            switch ($_POST['ordenado']) {
                case "fecha":
                    $ordenado='pp.created_on';
                    break;
                case "repetido":
                    $ordenado='pp.repetido';
                    break;
                case "producto":
                    $ordenado='dm.texto_breve';
                    break;
                case "cantidad":
                    $ordenado='pp.cantidad';
                    break;
                case "proveedor":
                    $ordenado='pr.nombre';
                    break;
                case "solicitante":
                    $ordenado='pp.solicitante';
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
        $model = $command->queryAll();
        if(isset($_POST['excel'])){
            \moonland\phpexcel\Excel::widget([
                'models' => $model,
                'mode' => 'export',
                'columns' => ['tipo_presupuesto','gasto_activo','codigo','material','proveedor','cantidad','precio_neto','solicitante','fecha','repetido','motivo_rechazo'],
                'headers' => [
                    'tipo_presupuesto' => 'TIPO PRESUPUESTO',
                    'gasto_activo' => 'GASTO/ACTIVO',
                    'codigo' => 'CODIGO',
                    'material' => 'MATERIAL',
                    'proveedor' => 'PROVEEDOR',
                    'cantidad'=>'CANTIDAD',
                    'precio_neto'=>'PRECIO NETO',
                    'solicitante'=>'SOLICITANTE',
                    'fecha'=>'FECHA',
                    'repetido'=>'REPETIDO',
                    'motivo_rechazo'=>'MOTIVO NO APROBADO'
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
        if($estado==1){
            $res.= $this->renderPartial('pedidos/_normal_partial', array(
            'model' => $model,
            'estado' => $estado,
                ), true);
        }else{
            $res.= $this->renderPartial('pedidos/_normal_partial_na', array(
            'model' => $model,
            'estado' => $estado,
                ), true);
        }
        
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'respuesta' => $res,
            'query' => $command->sql,
        ];
    }
    public function actionPedidosEspecial($estado=1){
        $array_post = Yii::$app->request->post();
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
        }
        $rows = (new \yii\db\Query())
        ->select("pp.gasto_activo gasto_activo, (CASE WHEN pp.precio_sugerido>=0 THEN pp.precio_sugerido ELSE pp.precio_neto END) precio_neto, pp.id id, pp.archivo archivo, (CASE WHEN pp.producto_sugerido = '' THEN dm.texto_breve ELSE pp.producto_sugerido END) material, pp.cantidad cantidad, pp.solicitante solicitante, DATE(pp.created_on) fecha, pp.repetido repetido, pp.tipo_presupuesto tipo_presupuesto, pp.motivo_rechazo motivo_rechazo")
        ->from('proyecto_pedido_especial pp, proyectos p, maestra_especial dm, proyecto_estado_pedidos pe')
        ->where('pp.proyecto_id='.$array_post['proyecto'].' AND p.id=pp.proyecto_id AND pp.maestra_especial_id=dm.id AND pp.estado_id=pe.id AND pp.estado_id='.$estado);
        if(isset($_POST['desde'])){
            if($_POST['desde']!="" && $_POST['hasta']!=""){
                $rows->andWhere("DATE(pp.created_on) between '".$_POST['desde']."' AND '".$_POST['hasta']."'");
            }
        }
        if(isset($_POST['buscar'])){
            if (trim($_POST['buscar'])!='') {
                $buscar=trim($_POST['buscar']);
                $rows->andWhere("pp.created_on like '%". $buscar."%' OR dm.texto_breve like '%".$buscar."%' OR pp.cantidad like '%".$buscar."%' OR pp.solicitante like '%".$buscar."%'");
            }
        }
        $rowsCount= clone $rows;
        $ordenado='dm.texto_breve';
        if(isset($_POST['ordenado'])){
            switch ($_POST['ordenado']) {
                case "fecha":
                    $ordenado='pp.created_on';
                    break;
                case "repetido":
                    $ordenado='pp.repetido';
                    break;
                case "producto":
                    $ordenado='dm.texto_breve';
                    break;
                case "cantidad":
                    $ordenado='pp.cantidad';
                    break;
                case "solicitante":
                    $ordenado='pp.solicitante';
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
        $model = $command->queryAll();
        if(isset($_POST['excel'])){
            \moonland\phpexcel\Excel::widget([
                'models' => $model,
                'mode' => 'export',
                'columns' => ['tipo_presupuesto','gasto_activo','material','cantidad','precio_neto','solicitante','fecha','repetido','motivo_rechazo'],
                'headers' => [
                    'tipo_presupuesto' => 'TIPO PRESUPUESTO',
                    'gasto_activo' => 'GASTO/ACTIVO',
                    'material' => 'MATERIAL',
                    'cantidad' => 'CANTIDAD',
                    'precio_neto'=>'PRECIO NETO',
                    'solicitante' => 'SOLICITANTE',
                    'fecha'=>'FECHA',
                    'repetido'=>'REPETIDO',
                    'motivo_rechazo'=>'MOTIVO NO APROBADO'
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
        if($estado==1){
            $res.= $this->renderPartial('pedidos/_especial_partial', array(
            'model' => $model,
            'estado' => $estado,
            'presupuesto' => $presupuesto = Proyectos::findOne($_POST['proyecto'])
                ), true);
        }else{
            $res.= $this->renderPartial('pedidos/_especial_partial_na', array(
            'model' => $model,
            'estado' => $estado,
            'presupuesto' => $presupuesto = Proyectos::findOne($_POST['proyecto'])
                ), true);
        }
        
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'respuesta' => $res,
            'query' => $command->sql,
        ];
    }
    public function actionProcesarPresupuestos(){
        $array_post = Yii::$app->request->post();
        $suma_total = 0;
        $suma_seguridad = 0;
        $suma_riesgo = 0;
        $suma_heas = 0;
        $command = Yii::$app->db->createCommand("SELECT COALESCE(SUM(precio_neto*cantidad),0) FROM proyecto_pedidos WHERE proyecto_id=".$array_post['proyecto']." AND tipo_presupuesto='seguridad' AND estado_id=1"
            );
        //$query=$command->sql;
        $suma_seguridad = $command->queryScalar();

        $command = Yii::$app->db->createCommand("SELECT COALESCE(SUM(precio_neto*cantidad),0) FROM proyecto_pedidos WHERE proyecto_id=".$array_post['proyecto']." AND tipo_presupuesto='riesgo' AND estado_id=1");
        $suma_riesgo = $command->queryScalar();

        $command = Yii::$app->db->createCommand("SELECT COALESCE(SUM(precio_neto*cantidad),0) FROM proyecto_pedidos WHERE proyecto_id=".$array_post['proyecto']." AND gasto_activo='activo' AND estado_id=1");
        $suma_activo = $command->queryScalar();

        $command = Yii::$app->db->createCommand("SELECT COALESCE(SUM(precio_neto*cantidad),0) FROM proyecto_pedidos WHERE proyecto_id=".$array_post['proyecto']." AND gasto_activo='gasto' AND estado_id=1");
        $suma_gasto = $command->queryScalar();


        /*****************************/
        $command = Yii::$app->db->createCommand("SELECT COALESCE(SUM(CASE WHEN precio_neto>=0 THEN precio_neto*cantidad ELSE precio_sugerido*cantidad END),0) FROM proyecto_pedido_especial WHERE proyecto_id=".$array_post['proyecto']." AND tipo_presupuesto='seguridad' AND estado_id=1"
            );
        $suma_seguridad = $suma_seguridad+$command->queryScalar();

        $command = Yii::$app->db->createCommand("SELECT COALESCE(SUM(CASE WHEN precio_neto>=0 THEN precio_neto*cantidad ELSE precio_sugerido*cantidad END),0) FROM proyecto_pedido_especial WHERE proyecto_id=".$array_post['proyecto']." AND tipo_presupuesto='riesgo' AND estado_id=1");
        $suma_riesgo = $suma_riesgo+$command->queryScalar();

        $command = Yii::$app->db->createCommand("SELECT COALESCE(SUM(CASE WHEN precio_neto>=0 THEN precio_neto*cantidad ELSE precio_sugerido*cantidad END),0) FROM proyecto_pedido_especial WHERE proyecto_id=".$array_post['proyecto']." AND gasto_activo='activo' AND estado_id=1");
        $suma_activo = $suma_activo+$command->queryScalar();

        $command = Yii::$app->db->createCommand("SELECT COALESCE(SUM(CASE WHEN precio_neto>=0 THEN precio_neto*cantidad ELSE precio_sugerido*cantidad END),0) FROM proyecto_pedido_especial WHERE proyecto_id=".$array_post['proyecto']." AND gasto_activo='gasto' AND estado_id=1");
        $suma_gasto = $suma_gasto+$command->queryScalar();

        $suma_total = $suma_seguridad+$suma_riesgo;

        $command = Yii::$app->db->createCommand(
            "UPDATE proyectos SET ".
            "suma_total=".$suma_total.", ".
            "suma_seguridad=".$suma_seguridad.", ".
            "suma_riesgo=".$suma_riesgo.", ".
            "suma_activo=".$suma_activo.", ".
            "suma_gasto=".$suma_gasto.
            " WHERE id=".$array_post['proyecto']);
        $command->execute();
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'suma_total' => $suma_total,
            'suma_seguridad' => $suma_seguridad,
            'suma_riesgo' => $suma_riesgo,
            'suma_activo' => $suma_activo,
            'suma_gasto' => $suma_gasto,
        ];
    }
    public function actionCambiarEstado(){
        if ($_POST['tipo']=='normal') {
            $model = ProyectoPedidos::findOne($_POST['producto']);
            if($model->cantidad==$_POST['cantidad']){
                $model->setAttribute('estado_id', $_POST['estado']);
                if(isset($_POST['motivo'])){
                    $model->setAttribute('motivo_rechazo', $_POST['motivo']);
                }else{
                    $model->setAttribute('motivo_rechazo', '');
                }
                if($model->save()){
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'respuesta' => true,
                    ];
                }else{
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'respuesta' => print_r($model->getErrors()),
                    ];
                }
            }else{
                $model_NA = new ProyectoPedidos();
                $model_NA->setAttribute('detalle_maestra_id', $model->detalle_maestra_id);
                $model_NA->setAttribute('proyecto_id', $model->proyecto_id);
                $model_NA->setAttribute('estado_id', $_POST['estado']);
                $model_NA->setAttribute('cantidad', $_POST['cantidad']);
                $model_NA->setAttribute('precio_neto', $model->precio_neto);
                $model_NA->setAttribute('observaciones', $model->observaciones);
                $model_NA->setAttribute('observacion_coordinador', $model->observacion_coordinador);
                $model_NA->setAttribute('motivo_rechazo', $_POST['motivo']);
                $model_NA->setAttribute('cebe', $model->cebe);
                $model_NA->setAttribute('orden_interna_gasto', $model->orden_interna_gasto);
                $model_NA->setAttribute('orden_interna_activo', $model->orden_interna_activo);
                $model_NA->setAttribute('tipo_presupuesto', $model->tipo_presupuesto);
                $model_NA->setAttribute('fecha_revision_coordinador', $model->fecha_revision_coordinador);
                $model_NA->setAttribute('created_on', $model->created_on);
                $model_NA->setAttribute('repetido', $model->repetido);
                $model_NA->setAttribute('solicitante', $model->solicitante);
                $model_NA->setAttribute('gasto_activo', $model->gasto_activo);

                $model->setAttribute('cantidad', ($model->cantidad-$_POST['cantidad']));
                if($model->save()){
                    $model_NA->save();
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'respuesta' => true,
                    ];
                }else{
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'respuesta' => print_r($model->getErrors()),
                    ];
                }
            }
        }else if ($_POST['tipo']=='especial') {
            $model = ProyectoPedidoEspecial::findOne($_POST['producto']);
            if($model->cantidad==$_POST['cantidad']){
                $model->setAttribute('estado_id', $_POST['estado']);
                if(isset($_POST['motivo'])){
                    $model->setAttribute('motivo_rechazo', $_POST['motivo']);
                }else{
                    $model->setAttribute('motivo_rechazo', '');
                }
                if($model->save()){
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'respuesta' => true,
                    ];
                }else{
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'respuesta' => print_r($model->getErrors()),
                    ];
                }
            }else{
                $model_NA = new ProyectoPedidoEspecial();
                $model_NA->setAttribute('producto_sugerido', $model->producto_sugerido);
                $model_NA->setAttribute('cantidad', $_POST['cantidad']);
                $model_NA->setAttribute('proveedor_sugerido', $model->proveedor_sugerido);
                $model_NA->setAttribute('precio_sugerido', $model->precio_sugerido);
                $model_NA->setAttribute('precio_neto', $model->precio_neto);
                $model_NA->setAttribute('observaciones', $model->observaciones);
                $model_NA->setAttribute('archivo', $model->archivo);
                $model_NA->setAttribute('maestra_especial_id', $model->maestra_especial_id);
                $model_NA->setAttribute('proyecto_id', $model->proyecto_id);
                $model_NA->setAttribute('estado_id', $_POST['estado']);
                $model_NA->setAttribute('cebe', $model->cebe);
                $model_NA->setAttribute('observacion_coordinador', $model->observacion_coordinador);
                $model_NA->setAttribute('motivo_rechazo', $_POST['motivo']);
                $model_NA->setAttribute('orden_interna_gasto', $model->orden_interna_gasto);
                $model_NA->setAttribute('orden_interna_activo', $model->orden_interna_activo);
                $model_NA->setAttribute('tipo_presupuesto', $model->tipo_presupuesto);
                $model_NA->setAttribute('fecha_revision_coordinador', $model->fecha_revision_coordinador);
                $model_NA->setAttribute('created_on', $model->created_on);
                $model_NA->setAttribute('repetido', $model->repetido);
                $model_NA->setAttribute('solicitante', $model->solicitante);
                $model_NA->setAttribute('gasto_activo', $model->gasto_activo);

                $model->setAttribute('cantidad', ($model->cantidad-$_POST['cantidad']));
                if($model->save()){
                    $model_NA->save();
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'respuesta' => true,
                    ];
                }else{
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'respuesta' => print_r($model->getErrors()),
                    ];
                }
            }
        }
    }
    public function actionSubirCotizacion(){
        $array_post = Yii::$app->request->post();
       // print_r($_FILES);
        
        $file = UploadedFile::getInstanceByName('file');
        $filename='';$respuesta;
        if ($file !== null) {
            $shortPath = 'uploads/presupuestos/';
            $ext            = end((explode(".", $file->name)));
            $name           = date('Ymd') . rand(1, 10000) . '' . $file->name;
            $path           = Yii::$app->basePath . '/web/uploads/presupuestos/' . $name;
            $filename = $shortPath . $name;
            $respuesta=$file->saveAs($path);
            $model = $this->findModel($array_post['presupuesto']);
            $model->setAttribute('archivo', $filename);
            $model->save();
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'respuesta' => $respuesta,
        ];
    }

    public function actionSubirarchivo(){

        $array_post = Yii::$app->request->post();
        print_r($array_post);
        
        //echo $array_post['ProyectoArchivo']['id_empresa'];
        $model = $this->findModel($array_post['presupuesto_id']);
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath = '/uploads/';       
        $images = UploadedFile::getInstances($model, 'image2');
        foreach($images as $image){
            //echo $image->name;
          if($image !== null)
          {
              $proyecto_archivo = new ProyectoArchivo();    
              $ext = end((explode(".", $image->name)));
              $name = date('Ymd').rand(1, 10000).''.$image->name;
              $path = Yii::$app->params['uploadPath'] . $name;
              


              foreach ($array_post['det_id'] as $row) {
               // echo $row.":".$shortPath. $name."<br>";

                // $proyecto_archivo->setAttribute('archivo',$shortPath. $name);
                // $proyecto_archivo->setAttribute('id_det_pedido',$row);
              
                // $proyecto_archivo->save();
                Yii::$app->db->createCommand()->insert('proyecto_archivo', [
                    'archivo' => $shortPath. $name,
                    'id_det_pedido' => $row,
                    'id_empresa'=>$array_post['ProyectoArchivo']['id_empresa']
                ])->execute();
                
                
              }
             
              $image->saveAs($path);
          }

        
        }

        Yii::$app->session->setFlash('success','<h3><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Cotizacion cargada correctamente</h3>');
        return $this->redirect(['view', 'id' => $model->id]);

    } 


    public function actionCotizaciones_archivos(){

        $array_post = Yii::$app->request->post();

        $proyecto_archivo = ProyectoArchivo::find()->where('id_det_pedido='.$array_post['id'])->all();

        $files='';
        $contador=0;
        foreach ($proyecto_archivo as $row) {

            $nombre_archivo=str_replace("/uploads/", '', $row->archivo);

            $files.='<a href="'.Url::to('@web').$row->archivo.'" download>
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>'.$nombre_archivo."-<b class=\"text-primary\"> <i class=\"fa fa-building\" aria-hidden=\"true\"></i>".$row->empresa->nombre."</b>
                    <br>";
            $contador++;
        }

        if ($contador==0) {
            $files='
                <div class="alert alert-danger" role="alert">
                    <h3><i class="fa fa-file-o" aria-hidden="true"></i> No existen archivos adjuntos</h3>
                </div>
            ';
        }
       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'respuesta' => $files,
                ];
    }


    public function actionGastoActivo(){
        if ($_POST['tipo']=='normal') {
            $model = ProyectoPedidos::findOne($_POST['producto']);
            $model->setAttribute('gasto_activo', $_POST['estado']);
            if($model->save()){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'respuesta' => true,
                ];
            }else{
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'respuesta' => print_r($model->getErrors()),
                ];
            }
        }else if ($_POST['tipo']=='especial') {
            $model = ProyectoPedidoEspecial::findOne($_POST['producto']);
            $model->setAttribute('gasto_activo', $_POST['estado']);
            if($model->save()){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'respuesta' => true,
                ];
            }else{
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'respuesta' => print_r($model->getErrors()),
                ];
            }
        }
    }
    public function actionGastoActivoMultiple(){
        $count=0;
        if ($_POST['tipo']=='normal') {
            if(trim($_POST['productos_id'])!=''){
                $array = explode(",",$_POST['productos_id']);
                if(count($array)>0){
                    foreach ($array as $valor) {
                        $model = ProyectoPedidos::findOne($valor);
                        $model->setAttribute('gasto_activo', $_POST['estado']);
                        if($model->save()){
                            $count++;
                        }
                    }
                }
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'respuesta' => $count,
            ];
        }else if ($_POST['tipo']=='especial') {
            if(trim($_POST['productos_id'])!=''){
               $array = explode(",",$_POST['productos_id']);
                if(count($array)>0){
                    foreach ($array as $valor) {
                        $model = ProyectoPedidoEspecial::findOne($valor);
                        $model->setAttribute('gasto_activo', $_POST['estado']);
                        if($model->save()){
                            $count++;
                        }
                    }
                } 
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'respuesta' => $count,
            ];
        }
    }
    public function actionGuardarDatos(){
        $model = Proyectos::findOne($_POST['proyecto']);
        $model->setAttribute('iva', $_POST['iva']);
        $model->setAttribute('orden_interna_gasto', $_POST['orden_interna_gasto']);
        $model->setAttribute('orden_interna_activo', $_POST['orden_interna_activo']);
        $model->setAttribute('metros_cuadrados', $_POST['metros2']);
        if($model->save()){
           
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'respuesta' => true,
                'orden_interna_gasto'=>$_POST['orden_interna_gasto'],
                'orden_interna_activo'=>$_POST['orden_interna_activo']
            ];
        }else{
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'respuesta' => print_r($model->getErrors()),
            ];
        }
    }
    public function actionCerrarPresupuesto(){
        $array_post = Yii::$app->request->post();
        $presupuesto = Proyectos::findOne($array_post['proyecto']);
        //crear un pedido
        $pedido = new Pedido();
        $proyecto=Proyectos::find()->where('id='.$array_post['proyecto'])->one();
        //$pedido->setAttribute('solicitante', Yii::$app->session['usuario-exito']);
        $pedido->setAttribute('solicitante', $proyecto->solicitante);
        $pedido->setAttribute('estado', 'P');
        $pedido->setAttribute('centro_costo_codigo', $presupuesto->ceco);
        date_default_timezone_set ( 'America/Bogota');
        $fecha = date('Y-m-d');
        $pedido->setAttribute('fecha', $fecha);
        $pedido->setAttribute('observaciones', 'X');
        $pedido->setAttribute('tipo', 'N');
        $pedido->setAttribute('especial', 'N');
        $pedido->setAttribute('orden_interna_gasto', $presupuesto->orden_interna_gasto);
        $pedido->setAttribute('orden_interna_activo', $presupuesto->orden_interna_activo);
        $pedido->setAttribute('fk_presupuesto_id', $presupuesto->id);
        $respuesta="";
        if ($pedido->save()) {
            //buscar los pedidos del proyecto
            $pedidos_normal = ProyectoPedidos::find()->where('proyecto_id='.$array_post['proyecto'])
            ->andWhere("estado_id<>2")
            ->all();
            $pedidos_especial = ProyectoPedidoEspecial::find()->where('proyecto_id='.$array_post['proyecto'])->all();
            //copiar 1 a 1 a las tablas de pedidos normal
            foreach ($pedidos_normal as $pn) {
                $modelo_detalle =new DetallePedido();
                $modelo_detalle->setAttribute('detalle_maestra_id', $pn->detalle_maestra_id);
                $modelo_detalle->setAttribute('pedido_id', $pedido->id);
                $modelo_detalle->setAttribute('estado', 'P');
                $modelo_detalle->setAttribute('cantidad', $pn->cantidad);
                $modelo_detalle->setAttribute('precio_neto', $pn->precio_neto);
                $modelo_detalle->setAttribute('observaciones', $pn->observaciones);
                $modelo_detalle->setAttribute('codigo_activo', '');
                $modelo_detalle->setAttribute('imputacion', $pn->detalleMaestra->imputacion);
                $modelo_detalle->setAttribute('ordinario', 'S');
                $modelo_detalle->setAttribute('cebe', $presupuesto->cecoo->cebe);
                $modelo_detalle->setAttribute('dep', $presupuesto->cecoo->nombre);
                $modelo_detalle->setAttribute('proveedor', $pn->detalleMaestra->maestra->proveedor->nombre);
                $modelo_detalle->setAttribute('repetido', $pn->repetido);
                date_default_timezone_set('America/Bogota');
                $fecha_hora = date("Y-m-d H:i:s");
                $modelo_detalle->setAttribute('created_on', $fecha_hora);
                if(!$modelo_detalle->save()){
                    $respuesta="";print_r($modelo_detalle->getErrors());exit();
                }
            }
            //copiar 1 a 1 a las tablas de pedidos especial
            /*foreach ($pedidos_especial as $pe) {
                $modelo_detalle_esp = new DetallePedidoEspecial();
                $modelo_detalle_esp->setAttribute('producto_sugerido', $pe->producto_sugerido);
                $modelo_detalle_esp->setAttribute('cantidad', $pe->cantidad);
                $modelo_detalle_esp->setAttribute('proveedor_sugerido', $pe->proveedor_sugerido);
                $modelo_detalle_esp->setAttribute('precio_sugerido', $pe->precio_sugerido);
                $modelo_detalle_esp->setAttribute('precio_neto', $pe->precio_neto);
                $modelo_detalle_esp->setAttribute('observaciones', $pe->observaciones);
                $modelo_detalle_esp->setAttribute('archivo', $presupuesto->archivo);
                $modelo_detalle_esp->setAttribute('maestra_especial_id', $pe->maestra_especial_id);
                $modelo_detalle_esp->setAttribute('pedido_id', $pedido->id);
                $modelo_detalle_esp->setAttribute('estado', 'P');
                $modelo_detalle_esp->setAttribute('imputacion', $pe->maestraEspecial->imputacion);
                $modelo_detalle_esp->setAttribute('cebe', $presupuesto->cecoo->cebe);
                $modelo_detalle_esp->setAttribute('dep', $presupuesto->cecoo->nombre);
                $modelo_detalle_esp->setAttribute('repetido', $pe->repetido);
                date_default_timezone_set('America/Bogota');
                $fecha_hora = date("Y-m-d H:i:s");
                $modelo_detalle_esp->setAttribute('created_on', $fecha_hora);
                if(!$modelo_detalle_esp->save()){
                    $respuesta="";print_r($modelo_detalle_esp->getErrors());exit();
                }
            }*/
            $command = Yii::$app->db->createCommand(
                "UPDATE proyectos SET ".
                "estado='CERRADO'".
                " WHERE id=".$array_post['proyecto']);
            $command->execute();
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'respuesta' => '',
        ];
    }
    public function actionEstadoPresupuesto(){
        $array_post = Yii::$app->request->post();
        $presupuesto = Proyectos::findOne($array_post['presupuesto']);
        if($presupuesto->estado=='ABIERTO'){
            $presupuesto->setAttribute('estado', 'CERRADO');
        }else if($presupuesto->estado=='CERRADO'){
            $presupuesto->setAttribute('estado', 'ABIERTO');
        }
        $presupuesto->save();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'respuesta' => $presupuesto->estado,
        ];
    }
}
