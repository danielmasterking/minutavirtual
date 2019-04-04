<?php

namespace app\controllers;

use app\models\CentroCosto;
use app\models\DetallePedido;
use app\models\DetallePedidoEspecial;
use app\models\Equivalencia;
use app\models\InconsistenciaEspecifica;
use app\models\InconsistenciaGeneral;
use app\models\InconsistenciaMaestra;
use app\models\InconsistenciaMarca;
use app\models\InconsistenciaMaterial;
use app\models\Pedido;
use app\models\Presupuesto;
use app\models\MaestraEspecial;
use app\models\Usuario;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * PedidoController implements the CRUD actions for Pedido model.
 */
class PedidoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['Cabecera', 'Historico', 'OrdenHistorico', 'HistoricoEspecial', 'OrdenHistoricoEspecial', 'Consolidar',
                    'ConsolidarEspecial', 'index', 'OrdenAsignada', 'OrdenAsignadaEspecial', 'ActivoAsignadoEspecial',
                    'ActivoAsignado', 'OrdenCompra', 'OrdenCompraEspecial', 'CodigoActivos', 'HistoricoFinanciera',
                    'HistoricoFinancieraEspecial', 'CodigoActivosEspecial', 'Revision', 'RevisionEspecial', 'RevisionTecnica',
                    'RevisionTecnicaEspecial', 'RevisionFinanciera', 'RevisionFinancieraEspecial', 'RegresarFinancieraFromActivo',
                    'RegresarFinancieraEspecialFromActivo', 'AprobarProductoGasto', 'AprobarProductoGastoEspecial', 'AprobarProductoProyecto',
                    'AprobarProductoProyectoEspecial', 'AprobarProductoTecnico', 'AprobarProductoTecnicoEspecial', 'AprobarProductoActivo',
                    'AprobarProductoActivoTodos', 'AprobarProductoCoordinadorTodos', 'AprobarProductoCoordinadorEspecialTodos',
                    'AprobarProductoTecnicoTodos', 'AprobarProductoTecnicoEspecialTodos', 'AprobarProductoActivoEspecialTodos',
                    'AprobarProductoGastoTodos', 'AprobarProductoProyectoTodos', 'AprobarProductoProyectoEspecialTodos',
                    'AprobarProductoGastoEspecialTodos', 'AprobarProductoActivoEspecial', 'RechazarProducto', 'RechazarProductoEspecial',
                    'RechazarProductoFinanciero', 'RechazarProductoFinancieroEspecial', 'RechazarProductoTecnico',
                    'RechazarProductoTecnicoEspecial', 'AprobarProducto', 'AprobarProductoEspecial', 'View', 'Create', 'CreateEspeciales',
                    'RechazarProductoCoordinadorTodos', 'RechazarProductoEspecialCoordinadorTodos', 'RechazarProductoTecnicoTodos', 'RechazarProductoEspecialTecnicoTodos', 'RechazarProductoFinancieroTodos', 'RechazarProductoEspecialFinancieroTodos',
                    'Update', 'Delete', 'EliminarPedido', 'EliminarPedidoEspecial'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['Cabecera', 'Historico', 'OrdenHistorico', 'HistoricoEspecial', 'OrdenHistoricoEspecial', 'Consolidar',
                            'ConsolidarEspecial', 'index', 'OrdenAsignada', 'OrdenAsignadaEspecial', 'ActivoAsignadoEspecial',
                            'ActivoAsignado', 'OrdenCompra', 'OrdenCompraEspecial', 'CodigoActivos', 'HistoricoFinanciera',
                            'HistoricoFinancieraEspecial', 'CodigoActivosEspecial', 'Revision', 'RevisionEspecial', 'RevisionTecnica',
                            'RevisionTecnicaEspecial', 'RevisionFinanciera', 'RevisionFinancieraEspecial', 'RegresarFinancieraFromActivo',
                            'RegresarFinancieraEspecialFromActivo', 'AprobarProductoGasto', 'AprobarProductoGastoEspecial', 'AprobarProductoProyecto',
                            'AprobarProductoProyectoEspecial', 'AprobarProductoTecnico', 'AprobarProductoTecnicoEspecial', 'AprobarProductoActivo',
                            'AprobarProductoActivoTodos', 'AprobarProductoCoordinadorTodos', 'AprobarProductoCoordinadorEspecialTodos',
                            'AprobarProductoTecnicoTodos', 'AprobarProductoTecnicoEspecialTodos', 'AprobarProductoActivoEspecialTodos',
                            'AprobarProductoGastoTodos', 'AprobarProductoProyectoTodos', 'AprobarProductoProyectoEspecialTodos',
                            'AprobarProductoGastoEspecialTodos', 'AprobarProductoActivoEspecial', 'RechazarProducto', 'RechazarProductoEspecial',
                            'RechazarProductoFinanciero', 'RechazarProductoFinancieroEspecial', 'RechazarProductoTecnico',
                            'RechazarProductoTecnicoEspecial', 'AprobarProducto', 'AprobarProductoEspecial', 'View', 'Create', 'CreateEspeciales',
                            'RechazarProductoCoordinadorTodos', 'RechazarProductoEspecialCoordinadorTodos', 'RechazarProductoTecnicoTodos', 'RechazarProductoEspecialTecnicoTodos', 'RechazarProductoFinancieroTodos', 'RechazarProductoEspecialFinancieroTodos',
                            'Update', 'Delete', 'EliminarPedido', 'EliminarPedidoEspecial'],
                        'roles'   => ['@'], //para usuarios logueados
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCabecera()
    {

        $pendientes = DetallePedido::find()->where(['estado' => 'I'])->orderBy(['proveedor' => SORT_ASC, 'dep' => SORT_ASC])->all();
        return $this->render('cabecera', ['pendientes' => $pendientes]);

    }

    public function actionHistorico()
    {
        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $llaves = array();
        $id_pendiente = '';
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
		}else{
			$per_page = $rowsPerPage; // Per page records
			$start = $page * $per_page;
			$cur_page = 1;
			$previous_btn = true;
			$next_btn = true;
			$first_btn = true;
			$last_btn = true;
		}
        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'orden-') !== false) {

                    $mensaje       = array_key_exists('orden-' . $id_pendiente, $array_post) ? $array_post['orden-' . $id_pendiente] : '';
                    $detallePedido = DetallePedido::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('orden_compra', $mensaje);

                        }
                        $detallePedido->save();
                    }
                }
            }
        }
        $rows = (new \yii\db\Query())
	    ->select(['dp.id id', 'DATE(dp.created_on) fecha','dp.repetido repetido','cc.nombre dependencia','dm.texto_breve producto','dp.cantidad cantidad','pr.nombre proveedor','dp.orden_compra orden','p.solicitante solicitante','dp.fecha_revision_coordinador fcoordinador','dp.fecha_revision_tecnica ftecnica','dp.fecha_revision_financiera ffinanciera','dp.observacion_coordinador ocoordinador','dp.observacion_tecnica otecnica','dp.observacion_financiera ofinanciera','dp.motivo_rechazo mrechazo','dp.estado estado'])
	    ->from('detalle_pedido dp, detalle_maestra dm, pedido p, proveedor pr, centro_costo cc, maestra_proveedor mp')
	    ->where('dp.pedido_id=p.id AND dp.detalle_maestra_id=dm.id AND p.centro_costo_codigo=cc.codigo AND dm.proveedor=pr.codigo AND dm.maestra_proveedor_id=mp.id AND pr.id=mp.proveedor_id');
		if(isset($_POST['desde'])){
			if($_POST['desde']!="" && $_POST['hasta']!=""){
				$rows->andWhere("DATE(dp.created_on) between '".$_POST['desde']."' AND '".$_POST['hasta']."'");
			}
		}
		if(isset($_POST['buscar'])){
			if (trim($_POST['buscar'])!='') {
				$buscar=trim($_POST['buscar']);
                $dependencia='';
                if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                    $dependencia=trim($_POST['dependencias2']);
                }
				$rows->andWhere("dp.created_on like '%". $buscar."%' OR dm.texto_breve like '%".$buscar."%' OR dp.cantidad like '%".$buscar."%' OR pr.nombre like '%".$buscar."%' OR dp.orden_compra like '%".$buscar."%' OR p.solicitante like '%".$buscar."%' OR dp.fecha_revision_coordinador like '%".$buscar."%' OR dp.fecha_revision_tecnica like '%".$buscar."%' OR dp.fecha_revision_financiera like '%".$buscar."%' OR dp.observacion_coordinador like '%".$buscar."%' OR dp.observacion_tecnica like '%".$buscar."%' OR dp.observacion_financiera like '%".$buscar."%' OR dp.motivo_rechazo like '%".$buscar."%'");
                if($dependencia!=''){
                    $rows->andWhere("cc.nombre like '%".$dependencia."%'");
                }
			}else if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                $rows->andWhere("cc.nombre like '%".$_POST['dependencias2']."%'");
            }
		}
		$rowsCount= clone $rows;
        $ordenado='dp.pedido_id';
        if(isset($_POST['ordenado'])){
            switch ($_POST['ordenado']) {
                case "fecha":
                    $ordenado='dp.created_on';
                    break;
                case "repetido":
                    $ordenado='dp.repetido';
                    break;
                case "dependencia":
                    $ordenado='cc.nombre';
                    break;
                case "producto":
                    $ordenado='dm.texto_breve';
                    break;
                case "cantidad":
                    $ordenado='dp.cantidad';
                    break;
                case "proveedor":
                    $ordenado='pr.nombre';
                    break;
                case "orden":
                    $ordenado='dp.orden_compra';
                    break;
                case "solicitante":
                    $ordenado='p.solicitante';
                    break;
                case "fcoordinador":
                    $ordenado='dp.fecha_revision_coordinador';
                    break;
                case "ftecnica":
                    $ordenado='dp.fecha_revision_tecnica';
                    break;
                case "ffinanciera":
                    $ordenado='dp.fecha_revision_financiera';
                    break;
                case "ocoordinador":
                    $ordenado='dp.observacion_coordinador';
                    break;
                case "otecnica":
                    $ordenado='dp.observacion_tecnica';
                    break;
                case "ofinanciera":
                    $ordenado='dp.observacion_financiera';
                    break;
                case "mrechazo":
                    $ordenado='dp.motivo_rechazo';
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
    	$pendientes = $command->queryAll();
        if(isset($_POST['excel'])){
            \moonland\phpexcel\Excel::widget([
                'models' => $pendientes,
                'mode' => 'export',
                'columns' => ['fecha','repetido','dependencia','producto','cantidad','proveedor','orden','solicitante','fcoordinador','ftecnica','ffinanciera','ocoordinador','otecnica','ofinanciera','mrechazo'],
                'headers' => [
                    'fecha' => 'FECHA',
                    'repetido' => 'REPETIDO?',
                    'dependencia' => 'DEPENDENCIA',
                    'producto'=>'PRODUCTO',
                    'cantidad'=>'CANTIDAD',
                    'proveedor'=>'PROVEEDOR',
                    'orden'=>'ORDEN COMPRA',
                    'solicitante'=>'SOLICITANTE',
                    'fcoordinador'=>'F_REV_COORDINADOR',
                    'ftecnica'=>'F_REV_TECNICA',
                    'ffinanciera'=>'F_REV_FINANCIERA',
                    'ocoordinador'=>'OBS_COORDINADOR',
                    'otecnica'=>'OBS_TECNICA',
                    'ofinanciera'=>'OBS_FINANCIERA',
                    'mrechazo'=>'MOTV_RECHAZO'
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
        $res.= $this->renderPartial('_historico_partial', array(
            'pendientes' => $pendientes,
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
        	return $this->render('historico',
            	['partial' => $res, 'historico' => 'active','dependencias' => CentroCosto::find()->all(),]);
        }
    }

    public function actionOrdenHistorico($id_detalle_producto, $no_orden)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);

        if ($pendiente != null) {

            $pendiente->setAttribute('orden_interna', $no_orden);
            $pendiente->save();

        }

        return $this->redirect('historico');

    }

    public function actionHistoricoEspecial()
    {
        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $llaves = array();
        $id_pendiente = '';
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
        }else{
            $per_page = $rowsPerPage; // Per page records
            $start = $page * $per_page;
            $cur_page = 1;
            $previous_btn = true;
            $next_btn = true;
            $first_btn = true;
            $last_btn = true;
        }
        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'orden-') !== false) {

                    $mensaje       = array_key_exists('orden-' . $id_pendiente, $array_post) ? $array_post['orden-' . $id_pendiente] : '';
                    $detallePedido = DetallePedidoEspecial::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('orden_compra', $mensaje);

                        }

                        $detallePedido->save();

                    }

                }

            }
        }
        $rows = (new \yii\db\Query())
        ->select(['dp.id id', 'DATE(dp.created_on) fecha','dp.repetido repetido','cc.nombre dependencia','me.texto_breve producto','dp.producto_sugerido psugerido','dp.cantidad cantidad','dp.proveedor_sugerido proveedor','dp.orden_compra orden','p.solicitante solicitante','dp.archivo cotizacion','dp.fecha_revision_coordinador fcoordinador','dp.fecha_revision_tecnica ftecnica','dp.fecha_revision_financiera ffinanciera','dp.observacion_coordinador ocoordinador','dp.observacion_tecnica otecnica','dp.observacion_financiera ofinanciera','dp.motivo_rechazo mrechazo','dp.estado estado'])
        ->from('detalle_pedido_especial dp, maestra_especial me, pedido p, centro_costo cc')
        ->where('dp.pedido_id=p.id AND dp.maestra_especial_id=me.id AND p.centro_costo_codigo=cc.codigo');
        if(isset($_POST['desde'])){
            if($_POST['desde']!="" && $_POST['hasta']!=""){
                $rows->andWhere("DATE(dp.created_on) between '".$_POST['desde']."' AND '".$_POST['hasta']."'");
            }
        }
        if(isset($_POST['buscar'])){
            if (trim($_POST['buscar'])!='') {
                $buscar=trim($_POST['buscar']);
                $dependencia='';
                if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                    $dependencia=trim($_POST['dependencias2']);
                }
                $rows->andWhere("dp.created_on like '%". $buscar."%' OR dp.producto_sugerido like '%".$buscar."%' OR me.texto_breve like '%".$buscar."%' OR dp.cantidad like '%".$buscar."%' OR dp.proveedor_sugerido like '%".$buscar."%' OR dp.orden_compra like '%".$buscar."%' OR p.solicitante like '%".$buscar."%' OR dp.fecha_revision_coordinador like '%".$buscar."%' OR dp.fecha_revision_tecnica like '%".$buscar."%' OR dp.fecha_revision_financiera like '%".$buscar."%' OR dp.observacion_coordinador like '%".$buscar."%' OR dp.observacion_tecnica like '%".$buscar."%' OR dp.observacion_financiera like '%".$buscar."%' OR dp.motivo_rechazo like '%".$buscar."%'");
                if($dependencia!=''){
                    $rows->andWhere("cc.nombre like '%".$dependencia."%'");
                }
            }else if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                $rows->andWhere("cc.nombre like '%".$_POST['dependencias2']."%'");
            }
        }
        $rowsCount= clone $rows;
        $ordenado='dp.pedido_id';
        if(isset($_POST['ordenado'])){
            switch ($_POST['ordenado']) {
                case "fecha":
                    $ordenado='dp.created_on';
                    break;
                case "repetido":
                    $ordenado='dp.repetido';
                    break;
                case "dependencia":
                    $ordenado='cc.nombre';
                    break;
                case "producto":
                    $ordenado='me.texto_breve';
                    break;
                case "cantidad":
                    $ordenado='dp.cantidad';
                    break;
                case "proveedor":
                    $ordenado='dp.proveedor_sugerido';
                    break;
                case "orden":
                    $ordenado='dp.orden_compra';
                    break;
                case "solicitante":
                    $ordenado='p.solicitante';
                    break;
                case "fcoordinador":
                    $ordenado='dp.fecha_revision_coordinador';
                    break;
                case "ftecnica":
                    $ordenado='dp.fecha_revision_tecnica';
                    break;
                case "ffinanciera":
                    $ordenado='dp.fecha_revision_financiera';
                    break;
                case "ocoordinador":
                    $ordenado='dp.observacion_coordinador';
                    break;
                case "otecnica":
                    $ordenado='dp.observacion_tecnica';
                    break;
                case "ofinanciera":
                    $ordenado='dp.observacion_financiera';
                    break;
                case "mrechazo":
                    $ordenado='dp.motivo_rechazo';
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
        $pendientes = $command->queryAll();
        if(isset($_POST['excel'])){
            \moonland\phpexcel\Excel::widget([
                'models' => $pendientes,
                'mode' => 'export',
                'columns' => ['fecha','repetido','dependencia','producto','psugerido','cantidad','proveedor','orden','solicitante','fcoordinador','ftecnica','ffinanciera','ocoordinador','otecnica','ofinanciera','mrechazo'],
                'headers' => [
                    'fecha' => 'FECHA',
                    'repetido' => 'REPETIDO?',
                    'dependencia' => 'DEPENDENCIA',
                    'producto'=>'PRODUCTO',
                    'psugerido'=>'PRODUCTO SUGERIDO',
                    'cantidad'=>'CANTIDAD',
                    'proveedor'=>'PROVEEDOR',
                    'orden'=>'ORDEN COMPRA',
                    'solicitante'=>'SOLICITANTE',
                    'fcoordinador'=>'F_REV_COORDINADOR',
                    'ftecnica'=>'F_REV_TECNICA',
                    'ffinanciera'=>'F_REV_FINANCIERA',
                    'ocoordinador'=>'OBS_COORDINADOR',
                    'otecnica'=>'OBS_TECNICA',
                    'ofinanciera'=>'OBS_FINANCIERA',
                    'mrechazo'=>'MOTV_RECHAZO'
                ], 
            ]);
        }
        $modelcount = $rowsCount->count();;
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
        $res.= $this->renderPartial('_historico_especial_partial', array(
            'pendientes' => $pendientes,
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
            return $this->render('historicoEspecial',
                ['partial' => $res, 'historico' => 'active','dependencias' => CentroCosto::find()->all(),]);
        }
    }

    public function actionOrdenHistoricoEspecial($id_detalle_producto, $no_orden)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);

        if ($pendiente != null) {

            $pendiente->setAttribute('orden_interna', $no_orden);
            $pendiente->save();

        }

        return $this->redirect('historico-especial');

    }

    //Consolidar Información.
    public function actionConsolidar()
    {

        $array_post = Yii::$app->request->post();

        //I --> pendiente por consolidar
        $pendientes = DetallePedido::find()->where(['estado' => 'I'])->orderBy(['dep' => SORT_ASC])->all();

        //Terminar Consolidado
        if (array_key_exists('finalizar', $array_post)) {

            foreach ($pendientes as $pen) {

                $pen->setAttribute('estado', 'C');
                $pen->save();

            }

        }

        if (array_key_exists('generar', $array_post)) {

            //generar equivalencias
            $equivalencias = Equivalencia::find()->all();

            foreach ($pendientes as $pen) {

                $inicio_cebe = substr($pen->pedido->dependencia->cebe, 0, 1);

                //actualizar cebe
                $pen->setAttribute('cebe', $pen->pedido->centro_costo_codigo);
                $pen->setAttribute('dep', $pen->pedido->dependencia->nombre);
                $pen->setAttribute('proveedor', $pen->producto->maestra->proveedor->nombre);
                $pen->save();
                //Guardar ids de pedido;

                foreach ($equivalencias as $e) {

                    //Imputación de elemento es igual
                    // a tipo configurado en equivalencia
                    if ($pen->imputacion == $e->tipo) {

                        //cuenta contable
                        if ($e->elemento == 'CC') {

                            if ($e->cebe == null || $e->cebe == '') {

                                if ($e->producto == null || $e->producto == '') {

                                    $pen->setAttribute('cuenta_contable', $e->cuenta);
                                    $pen->save();

                                } else {

                                    if ($pen->producto->material == $e->producto) {

                                        $pen->setAttribute('cuenta_contable', $e->cuenta);
                                        $pen->save();

                                    }

                                }

                            } else {

                                //consultar cebe para cuenta
                                if ($e->cebe == $inicio_cebe) {

                                    $pen->setAttribute('cuenta_contable', $e->cuenta);
                                    $pen->save();

                                }

                            }

                        } else {

                            //Orden interna
                            if ($e->cebe == null || $e->cebe == '') {

                                if ($e->producto == null || $e->producto == '') {

                                    if ($pen->pedido->dependencia->estado != 'D') {

                                        $pen->setAttribute('orden_interna', $e->cuenta);
                                        $pen->save();

                                    } else {

                                        //obtener de presupuesto
                                        $presupuesto = Presupuesto::find()->where(['centro_costo_codigo' => $pen->pedido->dependencia->codigo])->one();

                                        if ($presupuesto != null) {

                                            $pen->setAttribute('orden_interna', $presupuesto->orden_interna);
                                            $pen->save();

                                        }

                                    }

                                } else {

                                    if ($pen->producto->material == $e->producto) {

                                        $pen->setAttribute('orden_interna', $e->cuenta);
                                        $pen->save();

                                    }

                                }

                            } else {

                                //consultar cebe para cuenta
                                if ($e->cebe == $inicio_cebe) {

                                    $pen->setAttribute('orden_interna', $e->cuenta);
                                    $pen->save();

                                }

                            }

                        }

                        //Asignar Orden Interna Presupuesto
                        //obtener de presupuesto
                        $presupuesto = Presupuesto::find()->where(['centro_costo_codigo' => $pen->pedido->dependencia->codigo])->one();

                        if ($presupuesto != null) {

                            $pen->setAttribute('orden_interna', $presupuesto->orden_interna);
                            $pen->save();

                        }

                    }

                }

            }

        }

        //Gu

        $pendientes = DetallePedido::find()->where(['estado' => 'I'])->orderBy(['proveedor' => SORT_ASC, 'dep' => SORT_ASC])->all();

        ////////////////Variable pruebas

        $prueba = 0;
        $date   = date('Y-m-d', time());
        foreach ($pendientes as $key) {

            if ($key->fecha_revision_financiera == $date) {

                $prueba++;
            }

        }

        /////////////////

        //Armar id de pedidos
        $contador_pedido    = 1;
        $contador_posicion  = 1;
        $index              = 0;
        $array_id           = array();
        $array_pos          = array();
        $cebe_anterior      = '';
        $proveedor_anterior = '';

        foreach ($pendientes as $pen) {

            //Guardar ids
            if ($proveedor_anterior == '' && $cebe_anterior == '') {

                $proveedor_anterior = $pen->proveedor;
                $cebe_anterior      = $pen->cebe;
                $pen->setAttribute('id_pedido', $contador_pedido);
                $pen->setAttribute('posicion', $contador_posicion);
                $pen->save();
                //VarDumper::dump($pen->errors);

            } else {

                if ($pen->proveedor == $proveedor_anterior && $pen->cebe == $cebe_anterior) {

                    $contador_posicion++;
                    $pen->setAttribute('id_pedido', $contador_pedido);
                    $pen->setAttribute('posicion', $contador_posicion);
                    $pen->save();

                } else {

                    $contador_posicion = 1;
                    $contador_pedido   = $contador_pedido + 1;
                    $pen->setAttribute('id_pedido', $contador_pedido);
                    $pen->setAttribute('posicion', $contador_posicion);
                    $pen->save();
                    $cebe_anterior      = $pen->cebe;
                    $proveedor_anterior = $pen->proveedor;

                }

            }

        }

        return $this->render('consolidar', ['pendientes' => $pendientes, 'prueba' => $prueba]);

    }

    //Consolidar Información.
    public function actionConsolidarEspecial()
    {

        $array_post = Yii::$app->request->post();

        //I --> pendiente por consolidar
        $pendientes = DetallePedidoEspecial::find()->where(['estado' => 'I'])->orderBy(['dep' => SORT_ASC])->all();

        //Terminar Consolidado
        if (array_key_exists('finalizar', $array_post)) {

            foreach ($pendientes as $penT) {

                $penT->setAttribute('estado', 'C');
                $penT->save();
                //VarDumper::dump($pen->errors);

            }

        }

        if (array_key_exists('generar', $array_post)) {

            //generar equivalencias
            $equivalencias = Equivalencia::find()->all();

            foreach ($pendientes as $pen) {

                $inicio_cebe        = substr($pen->pedido->dependencia->cebe, 0, 1);
                $proveedor_sugerido = ($pen->proveedor_sugerido == null) ? ' ' : $pen->proveedor_sugerido;

                //actualizar cebe
                $pen->setAttribute('cebe', $pen->pedido->centro_costo_codigo);
                $pen->setAttribute('dep', $pen->pedido->dependencia->nombre);
                $pen->setAttribute('proveedor', $proveedor_sugerido);
                $pen->save();
                //Guardar ids de pedido;

                foreach ($equivalencias as $e) {

                    //Imputación de elemento es igual
                    // a tipo configurado en equivalencia
                    if ($pen->imputacion == $e->tipo) {

                        //cuenta contable
                        if ($e->elemento == 'CC') {

                            if ($e->cebe == null || $e->cebe == '') {

                                if ($e->producto == null || $e->producto == '') {

                                    $pen->setAttribute('cuenta_contable', $e->cuenta);
                                    $pen->save();

                                } else {

                                    if ($pen->maestra->material == $e->producto) {

                                        $pen->setAttribute('cuenta_contable', $e->cuenta);
                                        $pen->save();

                                    }

                                }

                            } else {

                                //consultar cebe para cuenta
                                if ($e->cebe == $inicio_cebe) {

                                    $pen->setAttribute('cuenta_contable', $e->cuenta);
                                    $pen->save();

                                }

                            }

                        } else {

                            //Orden interna
                            if ($e->cebe == null || $e->cebe == '') {

                                if ($e->producto == null || $e->producto == '') {

                                    if ($pen->pedido->dependencia->estado != 'D') {

                                        $pen->setAttribute('orden_interna', $e->cuenta);
                                        $pen->save();

                                    } else {

                                        //obtener de presupuesto
                                        $presupuesto = Presupuesto::find()->where(['centro_costo_codigo' => $pen->pedido->dependencia->codigo])->one();

                                        if ($presupuesto != null) {

                                            $pen->setAttribute('orden_interna', $presupuesto->orden_interna);
                                            $pen->save();

                                        }

                                    }

                                } else {

                                    if ($pen->maestra->material == $e->producto) {

                                        $pen->setAttribute('orden_interna', $e->cuenta);
                                        $pen->save();

                                    }

                                }

                            } else {

                                //consultar cebe para cuenta
                                if ($e->cebe == $inicio_cebe) {

                                    $pen->setAttribute('orden_interna', $e->cuenta);
                                    $pen->save();

                                }

                            }

                        }

                        //Asignar Orden Interna Presupuesto
                        //obtener de presupuesto
                        $presupuesto = Presupuesto::find()->where(['centro_costo_codigo' => $pen->pedido->dependencia->codigo])->one();

                        if ($presupuesto != null) {

                            $pen->setAttribute('orden_interna', $presupuesto->orden_interna);
                            $pen->save();

                        }

                    }

                }

            }

        }

        $pendientes = DetallePedidoEspecial::find()->where(['estado' => 'I'])->orderBy(['proveedor' => SORT_ASC, 'dep' => SORT_ASC])->all();
        //Armar id de pedidos
        $contador_pedido    = 1;
        $contador_posicion  = 1;
        $index              = 0;
        $array_id           = array();
        $array_pos          = array();
        $cebe_anterior      = '';
        $proveedor_anterior = '';

        foreach ($pendientes as $pen) {

            //Guardar ids
            if ($proveedor_anterior == '' && $cebe_anterior == '') {

                $proveedor_anterior = $pen->proveedor;
                $cebe_anterior      = $pen->cebe;
                $pen->setAttribute('id_pedido', $contador_pedido);
                $pen->setAttribute('posicion', $contador_posicion);
                $pen->save();
                //VarDumper::dump($pen->errors);

            } else {

                if ($pen->proveedor == $proveedor_anterior && $pen->cebe == $cebe_anterior) {

                    $contador_posicion++;
                    $pen->setAttribute('id_pedido', $contador_pedido);
                    $pen->setAttribute('posicion', $contador_posicion);
                    $pen->save();

                } else {

                    $contador_posicion = 1;
                    $contador_pedido   = $contador_pedido + 1;
                    $pen->setAttribute('id_pedido', $contador_pedido);
                    $pen->setAttribute('posicion', $contador_posicion);
                    $pen->save();
                    $cebe_anterior      = $pen->cebe;
                    $proveedor_anterior = $pen->proveedor;

                }

            }

        }

        return $this->render('consolidarEspecial', ['pendientes' => $pendientes]);
    }

    /**
     * Lists all Pedido models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Pedido::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOrdenAsignada($id_detalle_producto)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);

        if ($pendiente->orden_compra != null && $pendiente->orden_compra != '') {

            $pendiente->setAttribute('estado', 'O');
            $pendiente->save();

        } else {

            return $this->redirect('orden-compra');

        }

        return $this->redirect('orden-compra');
    }

    public function actionOrdenAsignadaEspecial($id_detalle_producto)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);

        if ($pendiente->orden_compra != null && $pendiente->orden_compra != '') {

            $pendiente->setAttribute('estado', 'O');
            $pendiente->save();

        } else {

            return $this->redirect('orden-compra-especial');

        }

        return $this->redirect('orden-compra-especial');

    }

    public function actionActivoAsignadoEspecial($id_detalle_producto)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);
        $pendiente->setAttribute('estado', 'I');
        $pendiente->save();

        return $this->redirect('codigo-activos-especial');
    }

    public function actionActivoAsignado($id_detalle_producto)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);
        $pendiente->setAttribute('estado', 'I');
        $pendiente->save();

        return $this->redirect('codigo-activos');
    }

    public function actionOrdenCompra()
    {

        $llaves = array();

        $id_pendiente = '';

        $array_post = Yii::$app->request->post();

        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'orden-') !== false) {

                    $mensaje       = array_key_exists('orden-' . $id_pendiente, $array_post) ? $array_post['orden-' . $id_pendiente] : '';
                    $detallePedido = DetallePedido::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('orden_compra', $mensaje);

                        }

                        $detallePedido->save();

                    }

                }

            }

        }

        $pendientes = DetallePedido::find()->where(['estado' => 'C'])->orderBy(['id_pedido' => SORT_ASC, 'posicion' => SORT_ASC])->all();

        return $this->render('ordenes', ['pendientes' => $pendientes, 'ordenes' => 'active']);
    }

    public function actionOrdenCompraEspecial()
    {

        $llaves = array();

        $id_pendiente = '';

        $array_post = Yii::$app->request->post();

        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'orden-') !== false) {

                    $mensaje       = array_key_exists('orden-' . $id_pendiente, $array_post) ? $array_post['orden-' . $id_pendiente] : '';
                    $detallePedido = DetallePedidoEspecial::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('orden_compra', $mensaje);

                        }

                        $detallePedido->save();

                    }

                }

            }

        }

        $pendientes = DetallePedidoEspecial::find()->where(['estado' => 'C'])->orderBy(['id' => SORT_ASC])->all();

        return $this->render('ordenesEspeciales', ['pendientes' => $pendientes, 'ordenes' => 'active']);
    }

    public function actionCodigoActivos()
    {

        $llaves = array();

        $id_pendiente = '';

        $array_post = Yii::$app->request->post();

        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'activo-') !== false) {

                    $mensaje       = array_key_exists('activo-' . $id_pendiente, $array_post) ? $array_post['activo-' . $id_pendiente] : '';
                    $detallePedido = DetallePedido::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('codigo_activo', $mensaje);

                        }

                        $detallePedido->save();

                    }

                }

            }

        }

        $pendientes = DetallePedido::find()->where(['estado' => 'B', 'imputacion' => 'A'])->orderBy(['pedido_id' => SORT_DESC])->all();

        return $this->render('activos', ['pendientes' => $pendientes, 'activos' => 'active']);
    }

    public function actionHistoricoFinanciera()
    {
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
        ->select('dp.id id, '.
            'DATE(dp.created_on) fecha, '.
            'dp.repetido repetido, '.
            'cc.nombre dependencia, '.
            'dp.cebe cebe, '.
            'dm.texto_breve producto, '.
            'dp.cantidad cantidad, '.
            'pr.nombre proveedor, '.
            'dp.orden_compra orden, '.
            'dp.codigo_activo codigo_activo, '.
            'dp.precio_neto precio_neto, '.
            '(dp.precio_neto * dp.cantidad) as `precio_total`, '.
            'dp.fecha_revision_financiera ffinanciera, '.
            'dp.observacion_financiera ofinanciera, '.
            'dp.motivo_rechazo mrechazo, '.
            'dp.estado estado')
        ->from('detalle_pedido dp, detalle_maestra dm, pedido p, proveedor pr, centro_costo cc, maestra_proveedor mp')
        ->where("dp.pedido_id=p.id AND dp.detalle_maestra_id=dm.id AND p.centro_costo_codigo=cc.codigo AND dm.proveedor=pr.codigo AND dp.estado NOT IN ('R','Y','F','T','A','P') AND dm.maestra_proveedor_id=mp.id AND pr.id=mp.proveedor_id");
        if(isset($_POST['desde'])){
            if($_POST['desde']!="" && $_POST['hasta']!=""){
                $rows->andWhere("DATE(dp.created_on) between '".$_POST['desde']."' AND '".$_POST['hasta']."'");
            }
        }
        if(isset($_POST['buscar'])){
            if (trim($_POST['buscar'])!='') {
                $buscar=trim($_POST['buscar']);
                $dependencia='';
                if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                    $dependencia=trim($_POST['dependencias2']);
                }
                $rows->andWhere("dp.created_on like '%". $buscar."%' OR dp.cebe like '%".$buscar."%' OR dm.texto_breve like '%".$buscar."%' OR dp.cantidad like '%".$buscar."%' OR pr.nombre like '%".$buscar."%' OR dp.orden_compra like '%".$buscar."%' OR dp.codigo_activo like '%".$buscar."%' OR dp.fecha_revision_financiera like '%".$buscar."%' OR dp.observacion_financiera like '%".$buscar."%' OR dp.motivo_rechazo like '%".$buscar."%'");
                if($dependencia!=''){
                    $rows->andWhere("cc.nombre like '%".$dependencia."%'");
                }
            }else if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                $rows->andWhere("cc.nombre like '%".$_POST['dependencias2']."%'");
            }
        }
        $rowsCount= clone $rows;
        $ordenado='dp.pedido_id';
        if(isset($_POST['ordenado'])){
            switch ($_POST['ordenado']) {
                case "fecha":
                    $ordenado='dp.created_on';
                    break;
                case "repetido":
                    $ordenado='dp.repetido';
                    break;
                case "dependencia":
                    $ordenado='cc.nombre';
                    break;
                case "cebe":
                    $ordenado='dp.cebe';
                    break;
                case "producto":
                    $ordenado='dm.texto_breve';
                    break;
                case "cantidad":
                    $ordenado='dp.cantidad';
                    break;
                case "proveedor":
                    $ordenado='pr.nombre';
                    break;
                case "orden":
                    $ordenado='dp.orden_compra';
                    break;
                case "codigo":
                    $ordenado='dp.codigo_activo';
                    break;
                case "ffinanciera":
                    $ordenado='dp.fecha_revision_financiera';
                    break;
                case "ofinanciera":
                    $ordenado='dp.observacion_financiera';
                    break;
                case "mrechazo":
                    $ordenado='dp.motivo_rechazo';
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
        $pendientes = $command->queryAll();
        if(isset($_POST['excel'])){
            \moonland\phpexcel\Excel::widget([
                'models' => $pendientes,
                'mode' => 'export',
                'columns' => ['fecha','repetido','dependencia','cebe','producto','cantidad','proveedor','orden','codigo_activo','precio_neto','precio_total','ffinanciera','ofinanciera','mrechazo'],
                'headers' => [
                    'fecha' => 'FECHA',
                    'repetido' => 'REPETIDO?',
                    'dependencia' => 'DEPENDENCIA',
                    'cebe'=>'CEBE',
                    'producto'=>'PRODUCTO',
                    'cantidad'=>'CANTIDAD',
                    'proveedor'=>'PROVEEDOR',
                    'orden'=>'ORDEN COMPRA',
                    'codigo_activo'=>'CODIGO ACTIVO',
                    'precio_neto'=>'PRECIO NETO',
                    'precio_total'=>'PRECIO TOTAL',
                    'ffinanciera'=>'F_REV_FINANCIERA',
                    'ofinanciera'=>'OBS_FINANCIERA',
                    'mrechazo'=>'MOTV_RECHAZO'
                ], 
            ]);
        }
        $modelcount = $rowsCount->count();;
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
        $res.= $this->renderPartial('_historico_financiero_partial', array(
            'pendientes' => $pendientes,
            'historico' => 'active',
            'modelcount' => $modelcount
                ), true);
        if(isset($_POST['page'])){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'respuesta' => $res,
                'query' => $command->sql,
            ];
        }else{
            return $this->render('historicoFinanciera',
                ['partial' => $res, 'historico' => 'active','dependencias' => CentroCosto::find()->all(),]);
        }
    }

    public function actionHistoricoFinancieraEspecial()
    {
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
        ->select('dp.id id, '.
            'DATE(dp.created_on) fecha, '.
            'dp.repetido repetido, '.
            'cc.nombre dependencia, '.
            'me.texto_breve producto, '.
            'dp.producto_sugerido producto_sugerido, '.
            'dp.cebe cebe, '.
            'dp.cantidad cantidad, '.
            'dp.proveedor_sugerido proveedor, '.
            'dp.orden_compra orden, '.
            'dp.codigo_activo codigo_activo, '.
            'IF(dp.precio_sugerido>0, dp.precio_sugerido, dp.precio_neto) as `precio_sugerido`, '.
            'IF(dp.precio_sugerido>0, (dp.precio_sugerido * dp.cantidad), (dp.precio_neto * dp.cantidad)) as `precio_total`, '.
            'dp.fecha_revision_financiera ffinanciera, '.
            'dp.observacion_financiera ofinanciera, '.
            'dp.motivo_rechazo mrechazo, '.
            'dp.estado estado')
        ->from('detalle_pedido_especial dp, maestra_especial me, pedido p, centro_costo cc')
        ->where('dp.pedido_id=p.id AND dp.maestra_especial_id=me.id AND p.centro_costo_codigo=cc.codigo');
        if(isset($_POST['desde'])){
            if($_POST['desde']!="" && $_POST['hasta']!=""){
                $rows->andWhere("DATE(dp.created_on) between '".$_POST['desde']."' AND '".$_POST['hasta']."'");
            }
        }
        if(isset($_POST['buscar'])){
            if (trim($_POST['buscar'])!='') {
                $buscar=trim($_POST['buscar']);
                $dependencia='';
                if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                    $dependencia=trim($_POST['dependencias2']);
                }
                $rows->andWhere("dp.created_on like '%". $buscar."%' OR dp.cebe like '%".$buscar."%' OR dp.producto_sugerido like '%".$buscar."%' OR me.texto_breve like '%".$buscar."%' OR dp.cantidad like '%".$buscar."%' OR dp.proveedor_sugerido like '%".$buscar."%' OR dp.orden_compra like '%".$buscar."%' OR dp.codigo_activo like '%".$buscar."%' OR dp.fecha_revision_financiera like '%".$buscar."%' OR dp.observacion_financiera like '%".$buscar."%' OR dp.motivo_rechazo like '%".$buscar."%'");
                if($dependencia!=''){
                    $rows->andWhere("cc.nombre like '%".$dependencia."%'");
                }
            }else if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                $rows->andWhere("cc.nombre like '%".$_POST['dependencias2']."%'");
            }
        }
        $rowsCount= clone $rows;
        $ordenado='dp.pedido_id';
        if(isset($_POST['ordenado'])){
            switch ($_POST['ordenado']) {
                case "fecha":
                    $ordenado='dp.created_on';
                    break;
                case "repetido":
                    $ordenado='dp.repetido';
                    break;
                case "dependencia":
                    $ordenado='cc.nombre';
                    break;
                case "cebe":
                    $ordenado='dp.cebe';
                    break;
                case "producto":
                    $ordenado='dm.texto_breve';
                    break;
                case "cantidad":
                    $ordenado='dp.cantidad';
                    break;
                case "proveedor":
                    $ordenado='dp.proveedor_sugerido';
                    break;
                case "orden":
                    $ordenado='dp.orden_compra';
                    break;
                case "codigo":
                    $ordenado='dp.codigo_activo';
                    break;
                case "ffinanciera":
                    $ordenado='dp.fecha_revision_financiera';
                    break;
                case "ofinanciera":
                    $ordenado='dp.observacion_financiera';
                    break;
                case "mrechazo":
                    $ordenado='dp.motivo_rechazo';
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
        $pendientes = $command->queryAll();
        if(isset($_POST['excel'])){
            \moonland\phpexcel\Excel::widget([
                'models' => $pendientes,
                'mode' => 'export',
                'columns' => ['fecha','repetido','dependencia','cebe','producto','cantidad','proveedor','orden','codigo_activo','precio_sugerido','precio_total','ffinanciera','ofinanciera','mrechazo'],
                'headers' => [
                    'fecha' => 'FECHA',
                    'repetido' => 'REPETIDO?',
                    'dependencia' => 'DEPENDENCIA',
                    'cebe'=>'CEBE',
                    'producto'=>'PRODUCTO',
                    'cantidad'=>'CANTIDAD',
                    'proveedor'=>'PROVEEDOR',
                    'orden'=>'ORDEN COMPRA',
                    'codigo_activo'=>'CODIGO ACTIVO',
                    'precio_sugerido'=>'PRECIO NETO',
                    'precio_total'=>'PRECIO TOTAL',
                    'ffinanciera'=>'F_REV_FINANCIERA',
                    'ofinanciera'=>'OBS_FINANCIERA',
                    'mrechazo'=>'MOTV_RECHAZO'
                ], 
            ]);
        }
        $modelcount = $rowsCount->count();;
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
        $res.= $this->renderPartial('_historico_financiero_especial_partial', array(
            'pendientes' => $pendientes,
            'historico' => 'active',
            'modelcount' => $modelcount
                ), true);
        if(isset($_POST['page'])){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'respuesta' => $res,
                'query' => $command->sql,
            ];
        }else{
            return $this->render('historicoFinancieraEspecial',
                ['partial' => $res, 'historico' => 'active','dependencias' => CentroCosto::find()->all(),]);
        }
    }

    public function actionCodigoActivosEspecial()
    {

        $llaves = array();

        $id_pendiente = '';

        $array_post = Yii::$app->request->post();

        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'activo-') !== false) {

                    $mensaje       = array_key_exists('activo-' . $id_pendiente, $array_post) ? $array_post['activo-' . $id_pendiente] : '';
                    $detallePedido = DetallePedidoEspecial::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('codigo_activo', $mensaje);

                        }

                        $detallePedido->save();

                    }

                }

            }

        }

        $pendientes = DetallePedidoEspecial::find()->where(['estado' => 'B', 'imputacion' => 'A'])->orderBy(['pedido_id' => SORT_DESC])->all();

        return $this->render('activosEspeciales', ['pendientes' => $pendientes, 'activos' => 'active']);
    }

    public function actionRevision()
    {   
        //$pendientes = DetallePedido::find()->where([ 'or',['estado' => ['P','E'] ] ])->orderBy(['pedido_id' => SORT_ASC])->all();
        $array_post = Yii::$app->request->post();

        $usuario      = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $zonasUsuario = array();
        $marcasUsuario = array();
        
        if ($usuario != null) {

            $zonasUsuario = $usuario->zonas;
            $marcasUsuario    = $usuario->marcas;

        }

        $llaves               = array();
        $id_pendiente         = '';
        $id_pendiente_rechazo = '';

        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'itemr-rechazo-') !== false) {

                    $tmp                  = explode('-', $key);
                    $id_pendiente_rechazo = $tmp[2];

                }

                //VarDumper::dump($id_pendiente_rechazo);

                if (strpos($key, 'mensaje-') !== false) {

                    $mensaje       = array_key_exists('mensaje-' . $id_pendiente, $array_post) ? $array_post['mensaje-' . $id_pendiente] : '';
                    $detallePedido = DetallePedido::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('observacion_coordinador', $mensaje);
                            $detallePedido->setAttribute('estado', 'E'); //E item colocado como pendiente por coordinador

                        }

                        $detallePedido->save();

                    }

                }

                if (strpos($key, 'mensaje-rechazo-') !== false) {

                    $mensaje       = array_key_exists('mensaje-rechazo-' . $id_pendiente_rechazo, $array_post) ? $array_post['mensaje-rechazo-' . $id_pendiente_rechazo] : '';
                    $detallePedido = DetallePedido::findOne($id_pendiente_rechazo);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('motivo_rechazo', $mensaje);
                            //$detallePedido->setAttribute('estado','E');//E item colocado como pendiente por coordinador
                            $detallePedido->save();
                            return $this->redirect(['rechazar-producto', 'id_detalle_producto' => $detallePedido->id]);
                        }

                    }

                }

            }

        }

        $pendientes = DetallePedido::find()->where(['or', ['estado' => ['P', 'E']]])->orderBy(['pedido_id' => SORT_ASC])->all();

        return $this->render('revision', [
            'pendientes'   => $pendientes,
            'zonasUsuario' => $zonasUsuario,
            'marcasUsuario' => $marcasUsuario,
        ]);
    }

    public function actionRevisionEspecial()
    {
        //$pendientes = DetallePedidoEspecial::find()->where([ 'or',['estado' => ['P','E'] ] ])->orderBy(['pedido_id' => SORT_DESC])->all();
        $array_post = Yii::$app->request->post();

        $usuario      = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $zonasUsuario = array();
        $marcasUsuario = array();
        
        if ($usuario != null) {

            $zonasUsuario = $usuario->zonas;
            
            $marcasUsuario    = $usuario->marcas;

        }

        $llaves       = array();
        $id_pendiente = '';

        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'itemr-rechazo-') !== false) {

                    $tmp                  = explode('-', $key);
                    $id_pendiente_rechazo = $tmp[2];

                }

                if (strpos($key, 'mensaje-') !== false) {

                    $mensaje       = array_key_exists('mensaje-' . $id_pendiente, $array_post) ? $array_post['mensaje-' . $id_pendiente] : '';
                    $detallePedido = DetallePedidoEspecial::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('observacion_coordinador', $mensaje);
                            $detallePedido->setAttribute('estado', 'E'); //E item colocado como pendiente por coordinador

                        }

                        $detallePedido->save();

                    }

                }

                if (strpos($key, 'mensaje-rechazo-') !== false) {

                    $mensaje       = array_key_exists('mensaje-rechazo-' . $id_pendiente_rechazo, $array_post) ? $array_post['mensaje-rechazo-' . $id_pendiente_rechazo] : '';
                    $detallePedido = DetallePedidoEspecial::findOne($id_pendiente_rechazo);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('motivo_rechazo', $mensaje);
                            //$detallePedido->setAttribute('estado','E');//E item colocado como pendiente por coordinador
                            $detallePedido->save();
                            return $this->redirect(['rechazar-producto-especial', 'id_detalle_producto' => $detallePedido->id]);
                        }

                    }

                }

            }

        }

        $pendientes = DetallePedidoEspecial::find()->where(['or', ['estado' => ['P', 'E']]])->orderBy(['pedido_id' => SORT_DESC])->all();

        return $this->render('revisionEspecial', [
            'pendientes'   => $pendientes,
            'zonasUsuario' => $zonasUsuario,
            'marcasUsuario' => $marcasUsuario,

        ]);
    }

    public function actionRevisionTecnica()
    {

        $array_post = Yii::$app->request->post();

        $llaves       = array();
        $id_pendiente = '';

        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'itemr-rechazo-') !== false) {

                    $tmp                  = explode('-', $key);
                    $id_pendiente_rechazo = $tmp[2];

                }

                if (strpos($key, 'mensaje-') !== false) {

                    $mensaje       = array_key_exists('mensaje-' . $id_pendiente, $array_post) ? $array_post['mensaje-' . $id_pendiente] : '';
                    $detallePedido = DetallePedido::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('observacion_tecnica', $mensaje);
                            $detallePedido->setAttribute('estado', 'W'); //W item colocado como pendiente por revisión técnica

                        }

                        $detallePedido->save();

                    }

                }

                if (strpos($key, 'mensaje-rechazo-') !== false) {

                    $mensaje       = array_key_exists('mensaje-rechazo-' . $id_pendiente_rechazo, $array_post) ? $array_post['mensaje-rechazo-' . $id_pendiente_rechazo] : '';
                    $detallePedido = DetallePedido::findOne($id_pendiente_rechazo);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('motivo_rechazo', $mensaje);
                            //$detallePedido->setAttribute('estado','E');//E item colocado como pendiente por coordinador
                            $detallePedido->save();
                            return $this->redirect(['rechazar-producto-tecnico', 'id_detalle_producto' => $detallePedido->id]);
                        }

                    }

                }

            }

        }

        $pendientes = DetallePedido::find()->where(['or', ['estado' => ['T', 'W']]])->orderBy(['pedido_id' => SORT_DESC])->all();

        return $this->render('revisionTecnica', [
            'pendientes' => $pendientes,
            'pedido'     => 'active',
        ]);
    }

    public function actionRevisionTecnicaEspecial()
    {

        $array_post = Yii::$app->request->post();

        $llaves       = array();
        $id_pendiente = '';

        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'itemr-rechazo-') !== false) {

                    $tmp                  = explode('-', $key);
                    $id_pendiente_rechazo = $tmp[2];

                }

                if (strpos($key, 'mensaje-') !== false) {

                    $mensaje       = array_key_exists('mensaje-' . $id_pendiente, $array_post) ? $array_post['mensaje-' . $id_pendiente] : '';
                    $detallePedido = DetallePedidoEspecial::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('observacion_tecnica', $mensaje);
                            $detallePedido->setAttribute('estado', 'W'); //W item colocado como pendiente por revisión técnica

                        }

                        $detallePedido->save();

                    }

                }

                if (strpos($key, 'mensaje-rechazo-') !== false) {

                    $mensaje       = array_key_exists('mensaje-rechazo-' . $id_pendiente_rechazo, $array_post) ? $array_post['mensaje-rechazo-' . $id_pendiente_rechazo] : '';
                    $detallePedido = DetallePedidoEspecial::findOne($id_pendiente_rechazo);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('motivo_rechazo', $mensaje);
                            //$detallePedido->setAttribute('estado','E');//E item colocado como pendiente por coordinador
                            $detallePedido->save();
                            return $this->redirect(['rechazar-producto-tecnico-especial', 'id_detalle_producto' => $detallePedido->id]);
                        }

                    }

                }

            }

        }

        $pendientes = DetallePedidoEspecial::find()->where(['or', ['estado' => ['T', 'W']]])->orderBy(['pedido_id' => SORT_DESC])->all();

        return $this->render('revisionTecnicaEspecial', [
            'pendientes' => $pendientes,
            'pedido'     => 'active',
        ]);
    }

    public function actionRevisionFinanciera()
    {

        $array_post = Yii::$app->request->post();

        $connection = Yii::$app->db;

        $llaves       = array();
        $id_pendiente = '';

        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'itemr-rechazo-') !== false) {

                    $tmp                  = explode('-', $key);
                    $id_pendiente_rechazo = $tmp[2];

                }

                if (strpos($key, 'mensaje-') !== false) {

                    $mensaje       = array_key_exists('mensaje-' . $id_pendiente, $array_post) ? $array_post['mensaje-' . $id_pendiente] : '';
                    $detallePedido = DetallePedido::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('observacion_financiera', $mensaje);
                            $detallePedido->setAttribute('estado', 'Z'); //Z item colocado como pendiente por financiera

                        }

                        $detallePedido->save();

                    }

                }

                if (strpos($key, 'mensaje-rechazo-') !== false) {

                    $mensaje       = array_key_exists('mensaje-rechazo-' . $id_pendiente_rechazo, $array_post) ? $array_post['mensaje-rechazo-' . $id_pendiente_rechazo] : '';
                    $detallePedido = DetallePedido::findOne($id_pendiente_rechazo);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('motivo_rechazo', $mensaje);
                            //$detallePedido->setAttribute('estado','E');//E item colocado como pendiente por coordinador
                            $detallePedido->save();
                            return $this->redirect(['rechazar-producto-financiero', 'id_detalle_producto' => $detallePedido->id]);
                        }

                    }

                }

            }

        }

        $pendientes = DetallePedido::find()->where(['or', ['estado' => ['F', 'Z']]])->orderBy(['pedido_id' => SORT_DESC])->all();

        foreach ($pendientes as $pen) {

            //actualizar cebe
            $pen->setAttribute('cebe', $pen->pedido->centro_costo_codigo);
            $pen->setAttribute('dep', $pen->pedido->dependencia->nombre);
            $pen->setAttribute('proveedor', $pen->producto->maestra->proveedor->nombre);
            $pen->save();

        }

        $pendientes = DetallePedido::find()->where(['or', ['estado' => ['F', 'Z']]])->orderBy(['dep' => SORT_ASC])->all();

        return $this->render('revisionFinanciera', [
            'pendientes' => $pendientes,
            'pedido'     => 'active',
        ]);
    }

    public function actionRevisionFinancieraEspecial()
    {

        $array_post = Yii::$app->request->post();

        $llaves       = array();
        $id_pendiente = '';

        if (isset($array_post)) {

            $llaves = array_keys($array_post);

            foreach ($llaves as $key) {

                if (strpos($key, 'item-') !== false) {

                    $tmp          = explode('-', $key);
                    $id_pendiente = $tmp[1];

                }

                if (strpos($key, 'itemr-rechazo-') !== false) {

                    $tmp                  = explode('-', $key);
                    $id_pendiente_rechazo = $tmp[2];

                }

                if (strpos($key, 'mensaje-') !== false) {

                    $mensaje       = array_key_exists('mensaje-' . $id_pendiente, $array_post) ? $array_post['mensaje-' . $id_pendiente] : '';
                    $detallePedido = DetallePedidoEspecial::findOne($id_pendiente);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('observacion_financiera', $mensaje);
                            $detallePedido->setAttribute('estado', 'Z'); //Z item colocado como pendiente por financiera

                        }

                        $detallePedido->save();

                    }

                }

                if (strpos($key, 'mensaje-rechazo-') !== false) {

                    $mensaje       = array_key_exists('mensaje-rechazo-' . $id_pendiente_rechazo, $array_post) ? $array_post['mensaje-rechazo-' . $id_pendiente_rechazo] : '';
                    $detallePedido = DetallePedidoEspecial::findOne($id_pendiente_rechazo);

                    if ($detallePedido != null) {

                        if (strlen($mensaje) > 1) {

                            $detallePedido->setAttribute('motivo_rechazo', $mensaje);
                            //$detallePedido->setAttribute('estado','E');//E item colocado como pendiente por coordinador
                            $detallePedido->save();
                            return $this->redirect(['rechazar-producto-financiero-especial', 'id_detalle_producto' => $detallePedido->id]);
                        }

                    }

                }

            }

        }

        $pendientes = DetallePedidoEspecial::find()->where(['or', ['estado' => ['F', 'Z']]])->orderBy(['pedido_id' => SORT_DESC])->all();

        foreach ($pendientes as $pen) {

            //actualizar cebe
            $pen->setAttribute('cebe', $pen->pedido->centro_costo_codigo);
            $pen->setAttribute('dep', $pen->pedido->dependencia->nombre);
            $pen->save();

        }

        $pendientes = DetallePedidoEspecial::find()->where(['or', ['estado' => ['F', 'Z']]])->orderBy(['dep' => SORT_ASC])->all();

        return $this->render('revisionFinancieraEspecial', [
            'pendientes' => $pendientes,
            'pedido'     => 'active',
        ]);
    }

    /************************************************/

    public function actionRegresarFinancieraFromActivo($id_detalle_producto)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);

        $pendiente->setAttribute('estado', 'F');

        $pendiente->save();

        return $this->redirect('codigo-activos');

    }

    public function actionRegresarFinancieraEspecialFromActivo($id_detalle_producto)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);

        $pendiente->setAttribute('estado', 'F');

        $pendiente->save();

        return $this->redirect('codigo-activos-especial');

    }

    /*************************************************/

    public function actionAprobarProductoGasto($id_detalle_producto)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);

        $pendiente->setAttribute('imputacion', 'K');
        $pendiente->setAttribute('estado', 'I');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_financiera', $fecha);

        $pendiente->save();

        return $this->redirect('revision-financiera');

    }

    public function actionAprobarProductoGastoEspecial($id_detalle_producto)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);

        $pendiente->setAttribute('imputacion', 'K');
        $pendiente->setAttribute('estado', 'I');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_financiera', $fecha);

        $pendiente->save();

        return $this->redirect('revision-financiera-especial');

    }

    public function actionAprobarProductoProyecto($id_detalle_producto)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);

        $pendiente->setAttribute('imputacion', 'F');
        $pendiente->setAttribute('estado', 'I');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_financiera', $fecha);
        $pendiente->save();

        return $this->redirect('revision-financiera');

    }

    public function actionAprobarProductoProyectoEspecial($id_detalle_producto)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);

        $pendiente->setAttribute('imputacion', 'F');
        $pendiente->setAttribute('estado', 'I');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_financiera', $fecha);
        $pendiente->save();

        return $this->redirect('revision-financiera-especial');

    }

    public function actionAprobarProductoTecnico($id_detalle_producto)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);

        //$pendiente->setAttribute('imputacion','A');
        $pendiente->setAttribute('estado', 'F');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_tecnica', $fecha);
        $pendiente->save();

        return $this->redirect('revision-tecnica');

    }

    public function actionAprobarProductoTecnicoEspecial($id_detalle_producto)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);

        //$pendiente->setAttribute('imputacion','A');
        $pendiente->setAttribute('estado', 'F');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_tecnica', $fecha);

        $pendiente->save();

        return $this->redirect('revision-tecnica-especial');

    }

    public function actionAprobarProductoActivo($id_detalle_producto)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);
        $pendiente->setAttribute('imputacion', 'A');
        $pendiente->setAttribute('estado', 'I');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_financiera', $fecha);
        $pendiente->save();
        return $this->redirect('revision-financiera');

    }

    public function actionAprobarProductoActivoTodos()
    {

        //$pendientes = DetallePedido::find()->where([ 'or',['estado' => ['F','Z'] ] ])->orderBy(['pedido_id' => SORT_DESC])->all();
        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        //VarDumper::dump($seleccionados);

        while ($index < $tamano) {

            $ped = DetallePedido::find()->where(['id' => $seleccionados[$index]])->one();

            if ($ped != null) {

                if ($ped->pedido->dependencia->estado != 'D') {

                    $ped->setAttribute('imputacion', 'A');
                    $ped->setAttribute('estado', 'I');
                    $fecha = date('Y-m-d', time());
                    $ped->setAttribute('fecha_revision_financiera', $fecha);
                    $ped->save();

                }

            }

            $index++;
        }

        return $this->redirect('revision-financiera');
        //return $this->render('view',['data' => $array_post]);

    }
    public function actionRechazarProductoCoordinadorTodos()
    {
        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {
            $ped = DetallePedido::find()->where(['id' => $seleccionados[$index]])->one();
            if ($ped != null) {
                $ped->setAttribute('estado', 'R');
                $fecha = date('Y-m-d', time());
                $ped->setAttribute('fecha_revision_coordinador', $fecha);
                $ped->setAttribute('motivo_rechazo', $array_post['mensaje-rechazo-todos']);
                $ped->save();
            }
            $index++;
        }
        return $this->redirect('revision');
    }
    public function actionRechazarProductoEspecialCoordinadorTodos()
    {
        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {
            $ped = DetallePedidoEspecial::find()->where(['id' => $seleccionados[$index]])->one();
            if ($ped != null) {
                $ped->setAttribute('estado', 'R');
                $fecha = date('Y-m-d', time());
                $ped->setAttribute('fecha_revision_coordinador', $fecha);
                $ped->setAttribute('motivo_rechazo', $array_post['mensaje-rechazo-todos']);
                $ped->save();
            }
            $index++;
        }
        return $this->redirect('revision-especial');
    }
    public function actionRechazarProductoTecnicoTodos()
    {
        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {
            $ped = DetallePedido::find()->where(['id' => $seleccionados[$index]])->one();
            if ($ped != null) {
                $ped->setAttribute('estado', 'Y');
                $fecha = date('Y-m-d', time());
                $ped->setAttribute('fecha_revision_tecnica', $fecha);
                $ped->setAttribute('motivo_rechazo', $array_post['mensaje-rechazo-todos']);
                $ped->save();
            }
            $index++;
        }
        return $this->redirect('revision-tecnica');
    }
    public function actionRechazarProductoEspecialTecnicoTodos()
    {
        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {
            $ped = DetallePedidoEspecial::find()->where(['id' => $seleccionados[$index]])->one();
            if ($ped != null) {
                $ped->setAttribute('estado', 'Y');
                $fecha = date('Y-m-d', time());
                $ped->setAttribute('fecha_revision_tecnica', $fecha);
                $ped->setAttribute('motivo_rechazo', $array_post['mensaje-rechazo-todos']);
                $ped->save();
            }
            $index++;
        }
        return $this->redirect('revision-tecnica-especial');
    }
    public function actionRechazarProductoFinancieroTodos()
    {
        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {
            $ped = DetallePedido::find()->where(['id' => $seleccionados[$index]])->one();
            if ($ped != null) {
                $ped->setAttribute('estado', 'V');
                $fecha = date('Y-m-d', time());
                $ped->setAttribute('fecha_revision_financiera', $fecha);
                $ped->setAttribute('motivo_rechazo', $array_post['mensaje-rechazo-todos']);
                $ped->save();
            }
            $index++;
        }
        return $this->redirect('revision-financiera');
    }
    public function actionRechazarProductoEspecialFinancieroTodos()
    {
        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {
            $ped = DetallePedidoEspecial::find()->where(['id' => $seleccionados[$index]])->one();
            if ($ped != null) {
                $ped->setAttribute('estado', 'V');
                $fecha = date('Y-m-d', time());
                $ped->setAttribute('fecha_revision_financiera', $fecha);
                $ped->setAttribute('motivo_rechazo', $array_post['mensaje-rechazo-todos']);
                $ped->save();
            }
            $index++;
        }
        return $this->redirect('revision-financiera-especial');
    }
    public function actionAprobarProductoCoordinadorTodos()
    {

        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {

            $ped = DetallePedido::find()->where(['id' => $seleccionados[$index]])->one();

            if ($ped != null) {
                
                $flag = 0;

                $material_producto = $ped->producto->material;
                $maestra_proveedor_id = $ped->producto->maestra_proveedor_id;
                $marca_dependencia_id = $ped->pedido->dependencia->marca_id;

                if ($material_producto != null) {

                    $inconsistencia_marca   = InconsistenciaMarca::find()->where(['material' => $material_producto, 'maestra_proveedor_id' => $maestra_proveedor_id,'marca_id' => $marca_dependencia_id])->all();
                    $inconsistencia_material   = InconsistenciaMaterial::find()->where(['material' => $material_producto, 'maestra_proveedor_id' => $maestra_proveedor_id])->all();
                    $inconsistencia_maestra = InconsistenciaMaestra::find()->where(['material' => $material_producto, 'maestra_proveedor_id' => $maestra_proveedor_id])->all();

                    //Si esta presente en inconsistencia maestra se debe enviar a revisión financiera.
                    if ($inconsistencia_maestra != null) {
                        
                        $flag = 1;
                        //Existe inconsistencia para Producto
                        $ped->setAttribute('estado', 'F');
                        $fecha = date('Y-m-d', time());
                        $ped->setAttribute('fecha_revision_coordinador', $fecha);
                        $ped->setAttribute('fecha_revision_tecnica', $fecha);
                        $ped->save();
                        

                    }
                    
                    //Si esta presente en inconsistencia material se debe enviar a revisión financiera.
                    if ($inconsistencia_material != null) {

                        $flag = 1;
                        //Existe inconsistencia para Producto
                        $ped->setAttribute('estado', 'F');
                        
                        $fecha = date('Y-m-d', time());
                        $ped->setAttribute('fecha_revision_coordinador', $fecha);
                        $ped->setAttribute('fecha_revision_tecnica', $fecha);
                        $ped->save();
                        

                    }   

                    //Si esta presente en inconsistencia marca se debe enviar a revisión financiera.
                    if ($inconsistencia_marca != null) {

                        $flag = 1;
                        //Existe inconsistencia para Producto
                        $ped->setAttribute('estado', 'F');
                        
                        $fecha = date('Y-m-d', time());
                        $ped->setAttribute('fecha_revision_coordinador', $fecha);
                        $ped->setAttribute('fecha_revision_tecnica', $fecha);
                        $ped->save();
                        

                    }                   

                    //fin revisión aprobaciones previas



                }

                
                if($flag == 0){
                    
                    $ped->setAttribute('estado', 'T');
                    $fecha = date('Y-m-d', time());
                    $ped->setAttribute('fecha_revision_coordinador', $fecha);
                    $ped->save();                   
                    
                }


            }

            $index++;
        }

        return $this->redirect('revision');

    }

    public function actionAprobarProductoCoordinadorEspecialTodos()
    {

        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {

            $ped = DetallePedidoEspecial::find()->where(['id' => $seleccionados[$index]])->one();

            if ($ped != null) {

                $ped->setAttribute('estado', 'T');
                $fecha = date('Y-m-d', time());
                $ped->setAttribute('fecha_revision_coordinador', $fecha);
                $ped->save();

            }

            $index++;
        }

        return $this->redirect('revisionEspecial');

    }

    public function actionAprobarProductoTecnicoTodos()
    {

        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {

            $ped = DetallePedido::find()->where(['id' => $seleccionados[$index]])->one();

            if ($ped != null) {

                $ped->setAttribute('estado', 'F');
                $fecha = date('Y-m-d', time());
                $ped->setAttribute('fecha_revision_tecnica', $fecha);
                $ped->save();

            }

            $index++;
        }

        return $this->redirect('revision-tecnica');

    }

    public function actionAprobarProductoTecnicoEspecialTodos()
    {

        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {

            $ped = DetallePedidoEspecial::find()->where(['id' => $seleccionados[$index]])->one();

            if ($ped != null) {

                $ped->setAttribute('estado', 'F');
                $fecha = date('Y-m-d', time());
                $ped->setAttribute('fecha_revision_tecnica', $fecha);
                $ped->save();

            }

            $index++;
        }

        return $this->redirect('revision-tecnica-especial');

    }

    public function actionAprobarProductoActivoEspecialTodos()
    {

        //$pendientes = DetallePedidoEspecial::find()->where([ 'or',['estado' => ['F','Z'] ] ])->orderBy(['pedido_id' => SORT_DESC])->all();
        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        //VarDumper::dump($seleccionados);

        while ($index < $tamano) {

            $ped = DetallePedidoEspecial::find()->where(['id' => $seleccionados[$index]])->one();

            if ($ped != null) {

                if ($ped->pedido->dependencia->estado != 'D') {

                    $ped->setAttribute('imputacion', 'A');
                    $ped->setAttribute('estado', 'I');
                    $fecha = date('Y-m-d', time());
                    $ped->setAttribute('fecha_revision_financiera', $fecha);
                    $ped->save();

                }

            }

            $index++;
        }

        return $this->redirect('revision-financiera-especial');

    }

    public function actionAprobarProductoGastoTodos()
    {

        //$pendientes = DetallePedido::find()->where([ 'or',['estado' => ['F','Z'] ] ])->orderBy(['pedido_id' => SORT_DESC])->all();
        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {

            $ped = DetallePedido::find()->where(['id' => $seleccionados[$index]])->one();

            if ($ped != null) {

                if ($ped->pedido->dependencia->estado != 'D') {

                    $ped->setAttribute('imputacion', 'K');
                    $ped->setAttribute('estado', 'I');
                    $fecha = date('Y-m-d', time());
                    $ped->setAttribute('fecha_revision_financiera', $fecha);
                    $ped->save();

                }

            }

            $index++;
        }

        return $this->redirect('revision-financiera');

    }

    public function actionAprobarProductoProyectoTodos()
    {

        //$pendientes = DetallePedido::find()->where([ 'or',['estado' => ['F','Z'] ] ])->orderBy(['pedido_id' => SORT_DESC])->all();
        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {

            $ped = DetallePedido::find()->where(['id' => $seleccionados[$index]])->one();

            if ($ped != null) {

                $ped->setAttribute('imputacion', 'F');
                $ped->setAttribute('estado', 'I');
                $fecha = date('Y-m-d', time());
                $ped->setAttribute('fecha_revision_financiera', $fecha);
                $ped->save();

            }

            $index++;
        }

        return $this->redirect('revision-financiera');

    }

    public function actionAprobarProductoProyectoEspecialTodos()
    {

        //$pendientes = DetallePedido::find()->where([ 'or',['estado' => ['F','Z'] ] ])->orderBy(['pedido_id' => SORT_DESC])->all();
        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        while ($index < $tamano) {

            $ped = DetallePedidoEspecial::find()->where(['id' => $seleccionados[$index]])->one();

            if ($ped != null) {

                $ped->setAttribute('imputacion', 'F');
                $ped->setAttribute('estado', 'I');
                $fecha = date('Y-m-d', time());
                $ped->setAttribute('fecha_revision_financiera', $fecha);
                $ped->save();

            }

            $index++;
        }

        return $this->redirect('revision-financiera-especial');

    }

    public function actionAprobarProductoGastoEspecialTodos()
    {

        $array_post    = Yii::$app->request->post(); // almacenar variables POST
        $seleccionados = array_key_exists('pedidos', $array_post) ? $array_post['pedidos'] : array();
        $tamano        = count($seleccionados);
        $index         = 0;

        //VarDumper::dump($seleccionados);

        while ($index < $tamano) {

            $ped = DetallePedidoEspecial::find()->where(['id' => $seleccionados[$index]])->one();

            if ($ped != null) {

                if ($ped->pedido->dependencia->estado != 'D') {

                    $ped->setAttribute('imputacion', 'K');
                    $ped->setAttribute('estado', 'I');
                    $fecha = date('Y-m-d', time());
                    $ped->setAttribute('fecha_revision_financiera', $fecha);
                    $ped->save();

                }

            }

            $index++;
        }

        return $this->redirect('revision-financiera-especial');

    }

    public function actionAprobarProductoActivoEspecial($id_detalle_producto)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);
        $pendiente->setAttribute('imputacion', 'A');
        $pendiente->setAttribute('estado', 'I');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_financiera', $fecha);
        $pendiente->save();
        return $this->redirect('revision-financiera-especial');

    }

    public function actionRechazarProducto($id_detalle_producto)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);

        $pendiente->setAttribute('estado', 'R');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_coordinador', $fecha);

        $pendiente->save();

        return $this->redirect('revision');

    }

    public function actionRechazarProductoEspecial($id_detalle_producto)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);

        $pendiente->setAttribute('estado', 'R');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_coordinador', $fecha);

        $pendiente->save();

        return $this->redirect('revision-especial');

    }

    public function actionRechazarProductoFinanciero($id_detalle_producto)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);

        $pendiente->setAttribute('estado', 'V');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_financiera', $fecha);

        $pendiente->save();

        return $this->redirect('revision-financiera');

    }

    public function actionRechazarProductoFinancieroEspecial($id_detalle_producto)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);

        $pendiente->setAttribute('estado', 'V');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_financiera', $fecha);

        $pendiente->save();

        return $this->redirect('revision-financiera-especial');

    }

    public function actionRechazarProductoTecnico($id_detalle_producto)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);

        $pendiente->setAttribute('estado', 'Y');
        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_tecnica', $fecha);

        $pendiente->save();

        return $this->redirect('revision-tecnica');

    }

    public function actionRechazarProductoTecnicoEspecial($id_detalle_producto)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);

        $pendiente->setAttribute('estado', 'Y');

        $fecha = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_tecnica', $fecha);

        $pendiente->save();

        return $this->redirect('revision-tecnica-especial');

    }

/**Inicio Aprobación Coordinador **/

    public function actionAprobarProducto($id_detalle_producto)
    {

        $pendiente = DetallePedido::findOne($id_detalle_producto);

        //Estado T para revisión Técnica
        //Estado F para revisión Financiera
        //Estado P Para revisión Coordinador

        if ($pendiente != null) {

            //Consultar si existen inconsistencias Generales
            //para productos de un mismo pedido
            $material_producto = $pendiente->producto->material;
            $maestra_proveedor_id = $pendiente->producto->maestra_proveedor_id;
            $marca_dependencia_id = $pendiente->pedido->dependencia->marca_id;

            if ($material_producto != null) {

                $inconsistencia_marca   = InconsistenciaMarca::find()->where(['material' => $material_producto, 'maestra_proveedor_id' => $maestra_proveedor_id,'marca_id' => $marca_dependencia_id])->all();
                $inconsistencia_material   = InconsistenciaMaterial::find()->where(['material' => $material_producto, 'maestra_proveedor_id' => $maestra_proveedor_id])->all();
                $inconsistencia_maestra = InconsistenciaMaestra::find()->where(['material' => $material_producto, 'maestra_proveedor_id' => $maestra_proveedor_id])->all();

                //Si esta presente en inconsistencia maestra se debe enviar a revisión financiera.
                if ($inconsistencia_maestra != null) {

                    //Existe inconsistencia para Producto
                    $pendiente->setAttribute('estado', 'F');
                    $fecha     = date('Y-m-d', time());
                    $pendiente->setAttribute('fecha_revision_coordinador', $fecha); 
                    $pendiente->setAttribute('fecha_revision_tecnica', $fecha);
                    $pendiente->save();
                    return $this->redirect('revision');


                }
                
                //Si esta presente en inconsistencia material se debe enviar a revisión financiera.
                if ($inconsistencia_material != null) {

                    //Existe inconsistencia para Producto
                    $pendiente->setAttribute('estado', 'F');
                    $fecha     = date('Y-m-d', time());
                    $pendiente->setAttribute('fecha_revision_coordinador', $fecha); 
                    $pendiente->setAttribute('fecha_revision_tecnica', $fecha);
                    $pendiente->save();
                    return $this->redirect('revision');


                }   

                //Si esta presente en inconsistencia marca se debe enviar a revisión financiera.
                if ($inconsistencia_marca != null) {

                    //Existe inconsistencia para Producto
                    $pendiente->setAttribute('estado', 'F');
                    $fecha     = date('Y-m-d', time());
                    $pendiente->setAttribute('fecha_revision_coordinador', $fecha); 
                    $pendiente->setAttribute('fecha_revision_tecnica', $fecha);                 
                    $pendiente->save();
                    return $this->redirect('revision');


                }                   

                //fin revisión aprobaciones previas



            }

            // Estado F en estado (pedido, detallePedido) indica item aprobado y sin inconsistencia
            $pendiente->setAttribute('estado', 'T');
            $fecha     = date('Y-m-d', time());
            $pendiente->setAttribute('fecha_revision_coordinador', $fecha);         
            $pendiente->save();
        }

        return $this->redirect('revision');

    }

/** Fin Aprobación Coordinador*/

    public function actionAprobarProductoEspecial($id_detalle_producto)
    {

        $pendiente = DetallePedidoEspecial::findOne($id_detalle_producto);
        $fecha     = date('Y-m-d', time());
        $pendiente->setAttribute('fecha_revision_coordinador', $fecha);
        //Estado T para revisión Técnica
        //Estado F para revisión Financiera
        //Estado P Para revisión Coordinador

        if ($pendiente != null) {

            //Consultar si existen inconsistencias Generales
            //para productos de un mismo pedido

            // Estado F en estado (pedido, detallePedido) indica item aprobado y sin inconsistencia
            $pendiente->setAttribute('estado', 'T');
            $pendiente->save();
        }

        return $this->redirect('revision-especial');

    }

    /**
     * Displays a single Pedido model.
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
     * Creates a new Pedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->session->setTimeout(5400);
        $model            = new Pedido();
        $array_post       = Yii::$app->request->post();
        $dependencias     = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
        $usuario          = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $zonasUsuario     = array();
        $marcasUsuario    = array();
        $distritosUsuario = array();

        if ($usuario != null) {

            $zonasUsuario     = $usuario->zonas;
            $marcasUsuario    = $usuario->marcas;
            $distritosUsuario = $usuario->distritos;

        }

        if ($model->load(Yii::$app->request->post())) {

            //guardar productos
            $cantidad    = array_key_exists('cantidad-productos', $array_post) ? $array_post['cantidad-productos'] : 0;
            $tipo_pedido = array_key_exists('tipo-pedido', $array_post) ? $array_post['tipo-pedido'] : '';

            //existen productos solicitados
            if ($cantidad > 0) {

                $model->setAttribute('observaciones', 'X');
                $model->save();
                //if($model->save()){

                //}else{
                    //print_r($model->getErrors());exit();
                //}

                $tipo = 'S';

                if ($tipo_pedido == 'on') {

                    $tipo = 'N';

                }

                //guardar productos solicitados
                for ($i = 1; $i <= $cantidad; $i++) {

                    $modelo_detalle = new DetallePedido();
                    $prod           = array_key_exists('sel-produ-' . $i, $array_post) ? $array_post['sel-produ-' . $i] : 0;
                    //VarDumper::dump($prod);
                    if ($prod != 0) {

                        $modelo_detalle->setAttribute('detalle_maestra_id', $prod);
                        $modelo_detalle->setAttribute('cebe', $model->centro_costo_codigo);
                        $cantidad_prod = $array_post['txt-cant-' . $i];
                        $obs_prod      = $array_post['txt-comentario-' . $i];
                        $precio_neto   = $array_post['price-' . $i];
                        $modelo_detalle->setAttribute('precio_neto', $precio_neto);
                        $modelo_detalle->setAttribute('cantidad', $cantidad_prod);
                        $modelo_detalle->setAttribute('observaciones', $obs_prod);
                        $modelo_detalle->setAttribute('pedido_id', $model->id);
                        $modelo_detalle->setAttribute('ordinario', $tipo);
                        date_default_timezone_set('America/Bogota');
                        $fecha_hora = date("Y-m-d H:i:s");
                        $modelo_detalle->setAttribute('created_on', $fecha_hora);
                        //validar para repetido. buscar en la tabla por detalle_maestra_id, cantidad y dependencia hace 182 dias(6 meses)
                        $sql = "SELECT * FROM detalle_pedido WHERE created_on BETWEEN DATE_SUB('".$fecha_hora."', INTERVAL 182 DAY) AND '".$fecha_hora."' AND detalle_maestra_id=".$prod." AND cantidad=".$cantidad_prod.' ORDER BY created_on LIMIT 1';
                        $repetido = DetallePedido::findBySql($sql);
                        $mrepetido = $repetido->all();
                        //echo $repetido->createCommand()->getRawSql();exit();
                        if(count($mrepetido)>0){
                            //con el modelo buscar los pedidos que tengan dependencia igual
                            $pedidos = Pedido::find();
                            foreach ($mrepetido as $key) {
                                $pedidos->orWhere(['id'=>$key->pedido_id]);
                            }
                            $pedidos->andWhere(['centro_costo_codigo'=>$model->centro_costo_codigo]);
                            $mpedidos=$pedidos->all();
                            if(count($mpedidos)>0){
                                $modelo_detalle->setAttribute('repetido', 'SI');
                            }

                            //echo $pedidos->createCommand()->getRawSql();exit();
                        }
                        
                        $modelo_detalle->save();

                    }

                }

            }

            $model = new Pedido();

            return $this->render('create', [
                'model'            => $model,
                'dependencias'     => $dependencias,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'zonasUsuario'     => $zonasUsuario,
                'normal'           => 'active',
                'done'             => '200',
                'usuario'          => $usuario,
            ]);

        } else {

            return $this->render('create', [
                'model'            => $model,
                'dependencias'     => $dependencias,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'zonasUsuario'     => $zonasUsuario,
                'normal'           => 'active',
                'usuario'          => $usuario,
            ]);
        }
    }

    public function actionCreateEspeciales()
    {
        Yii::$app->session->setTimeout(5400);
        $model                          = new Pedido();
        $array_post                     = Yii::$app->request->post();
        $dependencias                   = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();
        $usuario                        = Usuario::findOne(Yii::$app->session['usuario-exito']);
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath                      = '/uploads/';

        $zonasUsuario     = array();
        $marcasUsuario    = array();
        $distritosUsuario = array();

        if ($usuario != null) {

            $zonasUsuario     = $usuario->zonas;
            $marcasUsuario    = $usuario->marcas;
            $distritosUsuario = $usuario->distritos;

        }

        $cantidad = array_key_exists('cantidad-productos', $array_post) ? $array_post['cantidad-productos'] : 0;

        if ($model->load(Yii::$app->request->post())) {

            $file = UploadedFile::getInstance($model, 'file');
            //existen productos solicitados
            if ($cantidad > 0) {

                $model->save();
                $model->setAttribute('especial', 'S');
                $model->save();
                $rutaCotizacion = '';
                if ($file !== null) {
                    $model->archivo = $file->name;
                    $ext            = end((explode(".", $file->name)));
                    $name           = date('Ymd') . rand(1, 10000) . '' . $model->archivo;
                    $path           = Yii::$app->params['uploadPath'] . $name;
                    $model->archivo = $shortPath . $name;
                    $model->save();
                    $file->saveAs($path);
                    $rutaCotizacion = $model->archivo;

                }

                //guardar productos solicitados
                for ($i = 1; $i <= $cantidad; $i++) {

                    $modelo_detalle = new DetallePedidoEspecial();
                    $prod           = array_key_exists('sel-produ-' . $i, $array_post) ? $array_post['sel-produ-' . $i] : 0;
                    //VarDumper::dump($prod) ;
                    if ($prod != 0) {

                        $cantidad_prod = $array_post['txt-cant-' . $i];
                        $obs_prod      = $array_post['txt-prod-' . $i];
                        $precio='';
                        if($array_post['txt-precio-' . $i]!=''){
                            $precio        = str_replace(".", "", $array_post['txt-precio-' . $i]);
                        }else{
                            $precio        = $array_post['txt-precio-' . $i];
                        }
                        $proveedor     = $array_post['txt-proveedor-' . $i];
                        $precio_neto   = $array_post['price-' . $i];
                        $modelo_detalle->setAttribute('maestra_especial_id', $prod);
                        $modelo_detalle->setAttribute('cebe', $model->centro_costo_codigo);
                        $modelo_detalle->setAttribute('cantidad', $cantidad_prod);
                        if($obs_prod==''){
                            $maestra=MaestraEspecial::findOne($prod);
                            $obs_prod=$maestra->material.'-'.$maestra->texto_breve;
                        }
                        $modelo_detalle->setAttribute('producto_sugerido', $obs_prod);
                        $modelo_detalle->setAttribute('precio_sugerido', $precio);
                        $modelo_detalle->setAttribute('precio_neto', $precio_neto);
                        $modelo_detalle->setAttribute('proveedor_sugerido', $proveedor);
                        $modelo_detalle->setAttribute('pedido_id', $model->id);
                        date_default_timezone_set('America/Bogota');
                        $fecha_hora = date("Y-m-d H:i:s");
                        $modelo_detalle->setAttribute('created_on', $fecha_hora);
                        //validar para repetido. buscar en la tabla por detalle_maestra_id, cantidad y dependencia hace 182 dias(6 meses)
                        $stringPrecio='';
                        if($precio>0){
                            $stringPrecio=' AND precio_sugerido='.$precio;
                        }
                        $sql = "SELECT * FROM detalle_pedido_especial WHERE created_on BETWEEN DATE_SUB('".$fecha_hora."', INTERVAL 182 DAY) AND '".$fecha_hora."' AND maestra_especial_id=".$prod." AND cantidad=".$cantidad_prod.$stringPrecio.' ORDER BY created_on LIMIT 1';
                        $repetido = DetallePedidoEspecial::findBySql($sql);
                        $mrepetido = $repetido->all();
                        //echo $repetido->createCommand()->getRawSql();exit();
                        if(count($mrepetido)>0){
                            //con el modelo buscar los pedidos que tengan dependencia igual
                            $pedidos = Pedido::find();
                            foreach ($mrepetido as $key) {
                                $pedidos->orWhere(['id'=>$key->pedido_id]);
                            }
                            $pedidos->andWhere(['centro_costo_codigo'=>$model->centro_costo_codigo]);
                            $mpedidos=$pedidos->all();
                            if(count($mpedidos)>0){
                                $modelo_detalle->setAttribute('repetido', 'SI');
                            }

                            //echo $pedidos->createCommand()->getRawSql();exit();
                        }

                        if ($modelo_detalle->save()) {

                            $modelo_detalle->setAttribute('archivo', $rutaCotizacion);
                            $modelo_detalle->save();

                            /*if( array_key_exists('file-cot-'.$i,$_FILES) ){

                        if (is_uploaded_file($_FILES['file-cot-'.$i]['tmp_name'])) {

                        $name =  $_FILES['file-cot-'.$i]['name'];
                        $path = Yii::$app->params['uploadPath'] . $name;

                        if (move_uploaded_file($_FILES['file-cot-'.$i]['tmp_name'], $path)) {

                        $modelo_detalle->setAttribute('archivo', $shortPath.$name);
                        $modelo_detalle->save();
                        // VarDumper::dump($modelo_detalle->errors);

                        }

                        }

                        }*/

                        } else {

                            //VarDumper::dump($modelo_detalle->errors);
                            //Falló al Guardar
                            $model = new Pedido();

                            $cantidad = 0;

                            return $this->render('create', [
                                'model'            => $model,
                                'dependencias'     => $dependencias,
                                'marcasUsuario'    => $marcasUsuario,
                                'distritosUsuario' => $distritosUsuario,
                                'zonasUsuario'     => $zonasUsuario,
                                'especial'         => 'active',
                                'done'             => '500',
                                'usuario'          => $usuario,
                            ]);

                        }
                    }

                }

                //Guardar
                $model = new Pedido();

                $cantidad = 0;

                return $this->render('create', [
                    'model'            => $model,
                    'dependencias'     => $dependencias,
                    'marcasUsuario'    => $marcasUsuario,
                    'distritosUsuario' => $distritosUsuario,
                    'zonasUsuario'     => $zonasUsuario,
                    'especial'         => 'active',
                    'done'             => '200',
                    'usuario'          => $usuario,
                ]);

            } else {

                $model = new Pedido();

                $cantidad = 0;

                return $this->render('create', [
                    'model'            => $model,
                    'dependencias'     => $dependencias,
                    'marcasUsuario'    => $marcasUsuario,
                    'distritosUsuario' => $distritosUsuario,
                    'zonasUsuario'     => $zonasUsuario,
                    'especial'         => 'active',
                    'done'             => '500',
                    'usuario'          => $usuario,
                ]);

            }

        } else {

            return $this->render('create', [
                'model'            => $model,
                'dependencias'     => $dependencias,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'zonasUsuario'     => $zonasUsuario,
                'especial'         => 'active',
                'usuario'          => $usuario,
            ]);
        }
    }

    /**
     * Updates an existing Pedido model.
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
     * Deletes an existing Pedido model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionEliminarPedido($id)
    {
        DetallePedido::findOne($id)->delete();

        return $this->redirect(['historico']);
    }
    public function actionEliminarPedidoEspecial($id)
    {
        DetallePedidoEspecial::findOne($id)->delete();

        return $this->redirect(['historico-especial']);
    }
    /**
     * Finds the Pedido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pedido::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
