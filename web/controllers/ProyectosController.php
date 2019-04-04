<?php

namespace app\controllers;

use Yii;
use app\models\CentroCosto;
use app\models\Usuario;
use app\models\Proyectos;
use app\models\ProyectosPresupuesto;
use app\models\ProyectoPedidos;
use app\models\ProyectoPedidoEspecial;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex(){
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
        $query = (new \yii\db\Query())
        ->select('pr.id id, '.
            '(SELECT COUNT(pp.id) FROM proyecto_pedidos pp WHERE pr.id=pp.proyecto_id) normales,'.
            '(SELECT COUNT(pp.id) FROM proyecto_pedido_especial pp WHERE pr.id=pp.proyecto_id) especiales,'.
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
            'pr.presupuesto_heas presupuesto_heas')
        ->from('proyectos pr, centro_costo cc')
        ->where('pr.ceco=cc.codigo');
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
                'columns' => ['nombre','dependencia','presupuesto_total','presupuesto_seguridad','presupuesto_riesgo','presupuesto_heas','fecha_finalizacion'],
                'headers' => [
                    'nombre' => 'NOMBRE',
                    'dependencia' => 'DEPENDENCIA',
                    'presupuesto_total' => 'PRESUPUESTO TOTAL',
                    'presupuesto_seguridad'=>'PRESUPUESTO SEGURIDAD',
                    'presupuesto_riesgo'=>'PRESUPUESTO RIESGO',
                    'presupuesto_heas'=>'PRESUPUESTO HEAS',
                    'fecha_finalizacion'=>'FECHA FINALIZACION'
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
            ]);
        }
    }
    public function actionView($id){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionCreate(){
        $model = new Proyectos();
        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set('America/Bogota');
            $fecha = date('Y-m-d H:i:s',time());
            $model->setAttribute('solicitante', Yii::$app->session['usuario-exito']);
            $model->setAttribute('created_on', $fecha);
            if($model->save()){
                //guardar en la tabla presupuesto asignados
                $model_preps = new ProyectosPresupuesto();
                $model_preps->setAttribute('fk_proyectos', $model->id);
                $model_preps->setAttribute('presupuesto_seguridad', $model->presupuesto_seguridad);
                $model_preps->setAttribute('presupuesto_riesgo', $model->presupuesto_riesgo);
                $model_preps->setAttribute('presupuesto_heas', $model->presupuesto_heas);
                $model_preps->setAttribute('created_on', $model->created_on);
                if($model_preps->save()){
                    return $this->redirect('index');
                }else{
                    print_r($model_preps->getErrors());
                }
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
            return $this->render('create', [
                'model' => $model,
                'dependencias'     => $dependencias,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'zonasUsuario'     => $zonasUsuario,
            ]);
        }
    }
    public function actionUpdate($id){
        $model = $this->findModel($id);
        $array_post = Yii::$app->request->post();
        if (isset($array_post['Proyectos']['presupuesto_seguridad'])) {
            //print_r(Yii::$app->request->post());exit();
            date_default_timezone_set('America/Bogota');
            $fecha = date('Y-m-d H:i:s',time());
            $model->setAttribute('presupuesto_seguridad', 
                $model->presupuesto_seguridad+$array_post['Proyectos']['presupuesto_seguridad']
            );
            //echo $model->presupuesto_riesgo;exit();
            $model->setAttribute('presupuesto_riesgo', 
                $model->presupuesto_riesgo+$array_post['Proyectos']['presupuesto_riesgo']
            );
            $model->setAttribute('presupuesto_heas', 
                $model->presupuesto_heas+$array_post['Proyectos']['presupuesto_heas']
            );
            $model->setAttribute('presupuesto_total', 
                $model->presupuesto_seguridad+
                $model->presupuesto_riesgo+
                $model->presupuesto_heas
            );
            $model->setAttribute('modificado_por', Yii::$app->session['usuario-exito']);
            $model->setAttribute('modified_in', $fecha);
            if ($model->save()) {
                $model_preps = new ProyectosPresupuesto();
                $model_preps->setAttribute('fk_proyectos', $id);
                $model_preps->setAttribute('presupuesto_seguridad', $array_post['Proyectos']['presupuesto_seguridad']);
                $model_preps->setAttribute('presupuesto_riesgo', $array_post['Proyectos']['presupuesto_riesgo']);
                $model_preps->setAttribute('presupuesto_heas', $array_post['Proyectos']['presupuesto_heas']);
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
    }
    public function actionDelete($id){
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    protected function findModel($id){
        if (($model = Proyectos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionPedidosCreate($id="0",$ceco="0"){
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
    }
    public function actionPedidosCreateEspecial($id="0",$ceco="0"){
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
    }
    public function actionPedidosNormales(){
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
        ->select('dm.texto_breve material, pr.nombre proveedor, pp.cantidad cantidad, pp.solicitante solicitante, pr.codigo codigo, DATE(pp.created_on) fecha, pp.repetido repetido')
        ->from('proyecto_pedidos pp, proyectos p, detalle_maestra dm, proyecto_estado_pedidos pe, proveedor pr, maestra_proveedor mp')
        ->where('p.id='.$_POST['proyecto'].' AND pp.detalle_maestra_id=dm.id AND pp.estado_id=pe.id AND dm.proveedor=pr.codigo AND dm.maestra_proveedor_id=mp.id AND pr.id=mp.proveedor_id');
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
                'columns' => ['codigo','material','proveedor','cantidad','solicitante','fecha','repetido'],
                'headers' => [
                    'codigo' => 'CODIGO',
                    'material' => 'MATERIAL',
                    'proveedor' => 'PROVEEDOR',
                    'cantidad'=>'CANTIDAD',
                    'solicitante'=>'SOLICITANTE',
                    'fecha'=>'FECHA',
                    'repetido'=>'REPETIDO'
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
        $res.= $this->renderPartial('pedidos/_normal_partial', array(
            'model' => $model,
                ), true);
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'respuesta' => $res,
            'query' => $command->sql,
        ];
    }
    public function actionPedidosEspecial(){
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
        ->select('pp.archivo archivo, dm.texto_breve material, pp.cantidad cantidad, pp.solicitante solicitante, DATE(pp.created_on) fecha, pp.repetido repetido')
        ->from('proyecto_pedido_especial pp, proyectos p, maestra_especial dm, proyecto_estado_pedidos pe')
        ->where('p.id='.$_POST['proyecto'].' AND pp.maestra_especial_id=dm.id AND pp.estado_id=pe.id');
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
                'columns' => ['material','cantidad','solicitante','fecha','repetido'],
                'headers' => [
                    'material' => 'MATERIAL',
                    'cantidad' => 'CANTIDAD',
                    'solicitante' => 'SOLICITANTE',
                    'fecha'=>'FECHA',
                    'repetido'=>'REPETIDO'
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
        $res.= $this->renderPartial('pedidos/_especial_partial', array(
            'model' => $model,
                ), true);
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'respuesta' => $res,
            'query' => $command->sql,
        ];
    }
}
