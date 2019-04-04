<?php

namespace app\controllers;

use Yii;
use app\models\PrefacturaElectronica;
use app\models\PrefacturaElectronicaSearch;
use app\models\CentroCosto;
use app\models\Empresa;
use app\models\Zona;
use app\models\Usuario;
use app\models\ModeloPrefacturaElectronica;
use app\models\PrefacturaDispositivoFijoElectronico;
use app\models\PrefacturaDispositivoVariableElectronico;
use app\models\TipoAlarma;
use app\models\DescAlarma;
use app\models\MarcaAlarma;
use app\models\AreaDependencia;
use app\models\TipoServicioElectronica;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * PrefacturaelectronicaController implements the CRUD actions for PrefacturaElectronica model.
 */
class PrefacturaelectronicaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PrefacturaElectronica models.
     * @return mixed
     */
    public function actionIndex()
    {
        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        //permiso administrador
        $permisos = array();
        if( isset(Yii::$app->session['permisos-exito']) ){
            $permisos = Yii::$app->session['permisos-exito'];
        }

        //print_r($permisos);
        ///////////////////////
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

        if(!in_array("administrador", $permisos)){
            $rows = (new \yii\db\Query())
            ->select(['dp.id id', 'DATE(dp.created) fecha','dp.mes mes','dp.ano ano','dp.usuario usuario','cc.nombre dependencia','em.nombre empresa','dp.estado estado'])
            ->from('prefactura_electronica dp, centro_costo cc, empresa em,ciudad c,ciudad_zona cz,usuario_zona uz,marca m,usuario_marca um')
            ->where('dp.centro_costo_codigo=cc.codigo AND dp.empresa=em.nit')
            ->andWhere('cc.ciudad_codigo_dane=c.codigo_dane')
            ->andWhere('cc.ciudad_codigo_dane=c.codigo_dane')
            ->andWhere('c.codigo_dane=cz.ciudad_codigo_dane')
            ->andWhere('cz.zona_id=uz.zona_id')
            ->andWhere('cc.marca_id=m.id')
            ->andWhere('m.id=um.marca_id')
            ->andWhere("uz.usuario='".Yii::$app->session['usuario-exito']."'")
            ->andWhere("um.usuario='".Yii::$app->session['usuario-exito']."'");
        }else{
            $rows = (new \yii\db\Query())
            ->select(['dp.id id', 'DATE(dp.created) fecha','dp.mes mes','dp.ano ano','dp.usuario usuario','cc.nombre dependencia','em.nombre empresa','dp.estado estado'])
            ->from('prefactura_electronica dp, centro_costo cc, empresa em')
            ->where('dp.centro_costo_codigo=cc.codigo AND dp.empresa=em.nit');


            
        }

        //SI ES ADMIN MUESTRA TODAS DE LO CONTRARIO MUESTRA SOLO MIS FACTURAS
        /*if(!in_array("administrador", $permisos)){
            $rows->andWhere("dp.usuario='".Yii::$app->session['usuario-exito']."' ");
        }*/

        //////////////////////////////////////////////////////////////////////

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

        //BUSQUEDA POR MARCA
        if (isset($_POST['marca'])) {
            $rows->andWhere("dp.marca like '%".$_POST['marca']."%'");
        }


        ////////////////////

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
        $model_dispositivo=new PrefacturaDispositivoFijoElectronico();
        if($modelcount > $rowsPerPage){
           
            $res.=$this->renderPartial('_paginacion_partial', array(
                'cur_page' => $cur_page,
                'no_of_paginations' => $no_of_paginations,
                'first_btn' => $first_btn,
                'previous_btn' => $previous_btn,
                'next_btn' => $next_btn,
                'last_btn' => $last_btn,
                'modelcount' => $modelcount,
                'model_dispositivo'=>$model_dispositivo
            ), true);
        }
        $res.= $this->renderPartial('_partial', array(
            'prefacturas' => $prefacturas,
            'historico' => 'active', 'usuario' => $usuario,
            'modelcount' => $modelcount,
            'model_dispositivo'=>$model_dispositivo
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

    /**
     * Displays a single PrefacturaElectronica model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
       $dispositivos = PrefacturaDispositivoFijoElectronico::find()->where('id_prefactura_electronica='.$id)->all();
       $modelo=new  PrefacturaDispositivoFijoElectronico();
       $variables=PrefacturaDispositivoVariableElectronico::find()->where('id_prefactura_electronica='.$id)->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dispositivos' => $dispositivos,
            'modelo'=>$modelo,
            'variables'=>$variables
        ]);
    }

    /**
     * Creates a new PrefacturaElectronica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PrefacturaElectronica();
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

        if ($model->load(Yii::$app->request->post()) ) {

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

            $prefactura = PrefacturaElectronica::find()->where(['ano' => $model->ano,'mes' => $model->mes,'centro_costo_codigo' => $model->centro_costo_codigo])->one();

            if($prefactura == null){

                $modelo_prefactura = ModeloPrefacturaElectronica::find()->where("centro_costos_codigo='".$model->centro_costo_codigo."'")->all();

                if(count($modelo_prefactura)>0){
                    $model->save();
                    foreach ($modelo_prefactura as $mp) {

                        $pd = new PrefacturaDispositivoFijoElectronico();

                        $pd->setAttribute('estado', $mp->estado);
                        $pd->setAttribute('sistema', $mp->sistema);
                        $pd->setAttribute('id_tipo_alarma', $mp->id_tipo_alarma);
                        $pd->setAttribute('id_marca', $mp->id_marca);
                        $pd->setAttribute('referencia', $mp->referencia);
                        $pd->setAttribute('ubicacion', $mp->ubicacion);
                        $pd->setAttribute('zona_panel', $mp->zona_panel);
                        $pd->setAttribute('meses_pactados', $mp->meses_pactados);
                        $pd->setAttribute('fecha_inicio', $mp->fecha_inicio);
                        $pd->setAttribute('fecha_ultima_reposicion', $mp->fecha_ultima_reposicion);
                        $pd->setAttribute('valor_arrendamiento_mensual', $mp->valor_arrendamiento_mensual);
                        $pd->setAttribute('centro_costos_codigo', $mp->centro_costos_codigo);
                        $pd->setAttribute('id_desc', $mp->id_desc);
                        $pd->setAttribute('id_prefactura_electronica', $model->id);

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

    function actionCreatevariable($id){

        $this->layout = 'main_sin_menu';
        Yii::$app->session->setTimeout(5400);
        $array_post = Yii::$app->request->post();
        $roles      = Yii::$app->session['rol-exito'];
        $model      = new PrefacturaDispositivoVariableElectronico();

        $tipos_alarma=TipoAlarma::find()->orderBy(['nombre' => SORT_ASC])->all();
        $list_alarmas=ArrayHelper::map($tipos_alarma,'id','nombre');


        $marcas_alarma=MarcaAlarma::find()->orderBy(['nombre' => SORT_ASC])->all();
        $list_marcas_alarmas=ArrayHelper::map($marcas_alarma,'id','nombre');        

        $areas=AreaDependencia::find()->all();
        $list_areas=ArrayHelper::map($areas,'id','nombre');


        $servicios=TipoServicioElectronica::find()->all();
        $list_servicios=ArrayHelper::map($servicios,'id','nombre');        


        if ($model->load($array_post)) {
            $pf = PrefacturaElectronica::findOne($id);

            
            $model->setAttribute('fecha_inicio', $array_post['fecha_inicio']);
            $model->setAttribute('fecha_fin', $array_post['fecha_fin']);
            $model->setAttribute('valor_novedad', $array_post['prefacturadispositivovariableelectronico-valor_novedad-disp']);
            $model->setAttribute('centro_costos_codigo', $pf->centro_costo_codigo);
            $model->setAttribute('id_prefactura_electronica', $id);

            $model->save();
            Yii::$app->session->setFlash('success','Dispositivo creado correctamente');
            return $this->redirect(['view', 'id' => $id]);

        }else{

            return $this->render('crear_variable', [
                    'codigo_dependencia' => $id,
                    'model'              => $model,
                    'alarmas'=>$list_alarmas,
                    'marcas_alarma'=>$list_marcas_alarmas,
                    'areas'=>$list_areas,
                    'servicios'=>$list_servicios
                    ]);
        }


    }




    /**
     * Updates an existing PrefacturaElectronica model.
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
     * Deletes an existing PrefacturaElectronica model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionDeletedispositivo($id_disp,$id){
        $model= PrefacturaDispositivoVariableElectronico::findOne($id_disp);
        $model->delete();
        Yii::$app->session->setFlash('success','Dispositivo eliminado correctamente');
        return $this->redirect(['view', 'id' => $id]);
    } 

    /**
     * Finds the PrefacturaElectronica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PrefacturaElectronica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PrefacturaElectronica::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
