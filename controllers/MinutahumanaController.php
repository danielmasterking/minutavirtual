<?php

namespace app\controllers;

use Yii;
use app\models\MinutaHumana;
use app\models\MinutaHumanaSearch;
use app\models\TipoInvitado;
use app\models\TipoObservacion;
use app\models\Usuario;
use app\models\Empresa;
use app\models\Personas;
use app\models\CentroCosto;
use app\models\AreaDependencia;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;
use app\models\PuestosDependencia;

/**
 * MinutahumanaController implements the CRUD actions for MinutaHumana model.
 */
class MinutahumanaController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout="admin/main";
    
    public function behaviors()
    {
       return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'create','ventanainicio','salida','perason'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'create','ventanainicio','salida','perason'],
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

    /**
     * Lists all MinutaHumana models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new MinutaHumana();
        
        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);



        $empresas = array();
        if($usuario != null){
         
          $empresasUsuario = $usuario->empresas;

          foreach ($empresasUsuario as $value) {

            $sql=Empresa::find()->where('nit="'.$value->nit.'"')->one();
            //$empresas[$value->nit]=$sql->nombre;
            $empresas[]=$value->nit;
          }


        }

        ///array de dependencias
        $dependencias=CentroCosto::find()->where(' empresa="'.$empresas[0].'" ')->all();
        $list_dependencia=ArrayHelper::map($dependencias,'codigo','nombre');
        ////////////////////////
         //PAGINACION
             $page=0;$rowsPerPage=10;
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


            //DATOS

            $permisos = array();
            if( isset(Yii::$app->session['permisos-exito']) ){
              $permisos = Yii::$app->session['permisos-exito'];
            }

            $rows = (new \yii\db\Query())
             ->select(['m.id','m.cedula_persona','m.hora_entrada','m.hora_salida','m.fecha','emp.nombre empresa','u.usuario','CONCAT(p.nombres, " ", p.apellidos) Persona','cc.nombre dependencia','ti.nombre tipo_invitado','to.nombre tipo_observacion','m.observacion','m.puesto','m.observacion_salida'])
             ->from('minuta_humana m')
             ->leftJoin('tipo_invitado ti', 'm.tipo_invitado = ti.id')
             ->leftJoin('tipo_observacion to', 'm.tipo_observacion = to.id')
             ->leftJoin('empresa emp', 'm.nit_empresa = emp.nit')
             ->leftJoin('personas p', 'm.cedula_persona = p.cedula')
             ->leftJoin('usuario u', 'm.usuario = u.usuario')
             ->leftJoin('centro_costo cc', 'm.codigo_dependencia = cc.codigo')
             ->where('1=1');

            if (!in_array("administrador", $permisos)) {
              $rows->andWhere('(cc.codigo '.$in_final.') and (cc.empresa="'.$empresas[0].'" )');
            }

              if(isset($_POST['desde'])){
                if($_POST['desde']!="" && $_POST['hasta']!=""){
                    $rows->andWhere("DATE(m.fecha) between '".$_POST['desde']."' AND '".$_POST['hasta']."'");
                }
              }

              if(trim($_POST['dependencias2'])!=''){
                $rows->andWhere("cc.codigo like '%".$_POST['dependencias2']."%'");
              }

             if(isset($_POST['buscar'])){
                if (trim($_POST['buscar'])!='') {
                    $buscar=trim($_POST['buscar']);
                    $dependencia='';
                    if(trim($_POST['dependencias2'])!='' && trim($_POST['dependencias2'])!='0'){
                      $dependencia=trim($_POST['dependencias2']);
                    }
                    // $rows->andWhere("m.cedula_persona like '%". $buscar."%' OR p.nombres like '%".$buscar."%' OR p.apellidos like '%".$buscar."%' ");

                    $rows->andWhere("m.cedula_persona = '". $buscar."' OR p.nombres like '%".$buscar."' OR p.apellidos like '%".$buscar."' OR m.puesto like '%".$buscar."' OR cc.nombre like '%".$buscar."' ");

                    if($dependencia!=''){
                      $rows->andWhere("cc.codigo like '%".$dependencia."%'");
                    }
                }

            }


            $rowsCount= clone $rows;

            $ordenado='m.id';
            if(isset($_POST['ordenado'])){
            switch ($_POST['ordenado']) {
                case "puesto":
                    $ordenado='m.puesto';
                    break;
                case "cedula":
                    $ordenado='m.cedula_persona';
                    break;
                case "dependencia":
                    $ordenado='cc.nombre';
                    break;
                
                case "fecha":
                    $ordenado='m.fecha';
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
            $query = $command->queryAll();

          if(isset($_POST['excel'])){
            \moonland\phpexcel\Excel::widget([
                'models' => $query,
                'mode' => 'export',
                'fileName' => 'Reporte Ingreso Personas', 
                'columns' => ['cedula_persona','Persona','tipo_invitado','tipo_observacion','hora_entrada','hora_salida','puesto','fecha','dependencia','usuario','observacion','observacion_salida'],
                'headers' => [
                    'cedula_persona' => 'Cedula',
                    'Persona' => 'Persona',
                    'tipo_invitado' => 'Tipo Invitado',
                    'tipo_observacion'=>'Tipo Observacion',
                    'hora_entrada'=>'Hora Entrada',
                    'hora_salida'=>'Hora Salida',
                    'puesto'=>'Puesto',
                    'fecha'=>'Fecha',
                    'dependencia'=>'Dependencia',
                    'usuario'=>'Usuario',
                    'observacion'=>'Observacion adicional',
                    'observacion_salida'=>'Observacion salida'
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
                    'modelcount' => $modelcount,
                    
                ), true);
            }

             $res.= $this->renderPartial('_partial_informe', array(
            'query' => $query,
            'modelcount' => $modelcount,
    
                ), true);

            if(isset($_POST['page'])){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'respuesta' => $res,
                    'query' => $command->sql,
                ];
            }else{
                return $this->render('index', [
                    'partial' => $res,
                    'model' => $model,
                    'list_dependencia'=>$list_dependencia
                ]);
            }
        
    }


    public function actionVentanainicio(){
        $conteo_dia=MinutaHumana::find()->where('fecha="'.date('Y-m-d').'"')->count();
        return $this->render('ventana_inicio', [
           'conteo_dia'=>$conteo_dia
        ]);
    }

    public function actionImprimir(){
      $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
      $empresas = array();
      $logo_emp='';
      if($usuario != null){
         
        $empresasUsuario = $usuario->empresas;

        foreach ($empresasUsuario as $value) {

          $sql=Empresa::find()->where('nit="'.$value->nit.'"')->one();
          //$empresas[$value->nit]=$sql->nombre;
          //$empresas[]=$value->nit;
          $logo_emp=$sql->logo;
        }


      }


      $permisos = array();
      if( isset(Yii::$app->session['permisos-exito']) ){
        $permisos = Yii::$app->session['permisos-exito'];
      }

      $rows = (new \yii\db\Query())
       ->select(['m.id','m.cedula_persona','m.hora_entrada','m.hora_salida','m.fecha','emp.nombre empresa','u.usuario','CONCAT(p.nombres, " ", p.apellidos) Persona','cc.nombre dependencia','ti.nombre tipo_invitado','to.nombre tipo_observacion','m.observacion','m.puesto','m.observacion_salida'])
       ->from('minuta_humana m')
       ->leftJoin('tipo_invitado ti', 'm.tipo_invitado = ti.id')
       ->leftJoin('tipo_observacion to', 'm.tipo_observacion = to.id')
       ->leftJoin('empresa emp', 'm.nit_empresa = emp.nit')
       ->leftJoin('personas p', 'm.cedula_persona = p.cedula')
       ->leftJoin('usuario u', 'm.usuario = u.usuario')
       ->leftJoin('centro_costo cc', 'm.codigo_dependencia = cc.codigo')
       ->where('1=1');

        if (!in_array("administrador", $permisos)) {
          $rows->andWhere('(cc.codigo '.$in_final.') and (cc.empresa="'.$sql->nit.'" )');
        }

        if(isset($_REQUEST['desde'])){
          if($_REQUEST['desde']!="" && $_REQUEST['hasta']!=""){
              $rows->andWhere("DATE(m.fecha) between '".$_REQUEST['desde']."' AND '".$_REQUEST['hasta']."'");
          }
        }

        if(isset($_REQUEST['buscar'])){
          if (trim($_REQUEST['buscar'])!='') {
              $buscar=trim($_REQUEST['buscar']);
              $dependencia='';
              if(trim($_REQUEST['dependencias2'])!='' && trim($_REQUEST['dependencias2'])!='0'){
                $dependencia=trim($_REQUEST['dependencias2']);
              }
              // $rows->andWhere("m.cedula_persona like '%". $buscar."%' OR p.nombres like '%".$buscar."%' OR p.apellidos like '%".$buscar."%' ");

              $rows->andWhere("m.cedula_persona = '". $buscar."' OR p.nombres like '%".$buscar."' OR p.apellidos like '%".$buscar."' OR m.puesto like '%".$buscar."' OR cc.nombre like '%".$buscar."' ");

              if($dependencia!=''){
                $rows->andWhere("cc.codigo like '%".$dependencia."%'");
              }
          }

      }

      $ordenado='m.id';
            if(isset($_REQUEST['ordenado'])){
            switch ($_REQUEST['ordenado']) {
                case "puesto":
                    $ordenado='m.puesto';
                    break;
                case "cedula":
                    $ordenado='m.cedula_persona';
                    break;
                case "dependencia":
                    $ordenado='cc.nombre';
                    break;
                
                case "fecha":
                    $ordenado='m.fecha';
                    break;
            }
        }
        if(isset($_REQUEST['forma'])){
            if($_REQUEST['forma']=='SORT_ASC'){
                $rows->orderBy([$ordenado => SORT_ASC]);
            }else{
                $rows->orderBy([$ordenado => SORT_DESC]);
            }
        }else{
            $rows->orderBy([$ordenado => SORT_DESC]);
        }

        $command = $rows->createCommand();
            //echo $command->sql;exit();
        $query = $command->queryAll();

        $content = $this->renderPartial('_imprimir', array(
            'query' => $query,
            'logo_emp'=>$logo_emp
            
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
            'options' => ['title' => 'Reporte Ingreso De Personas'],
             // call mPDF methods on the fly
            'methods' => [ 
                //'SetHeader'=>['Reporte Ingreso De Personas'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    /**
     * Displays a single MinutaHumana model.
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
     * Creates a new MinutaHumana model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MinutaHumana();
        $personas=new Personas();
        
        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $areas=AreaDependencia::find()->all();


        $empresas = array();
        if($usuario != null){
         
          $empresasUsuario = $usuario->empresas;

          foreach ($empresasUsuario as $value) {

            $sql=Empresa::find()->where('nit="'.$value->nit.'"')->one();
            //$empresas[$value->nit]=$sql->nombre;
            $empresas[]=$value->nit;
          }


        }


        $dependencias_user=$this->dependencias_usuario(Yii::$app->session['usuario-exito']);

        $in=" IN(";

        foreach ($dependencias_user as $value) {
            
            $in.=" '".$value."',";    
        }

        $in_final = substr($in, 0, -1).")";

        $dependencias=CentroCosto::find()->where('codigo '.$in_final.' AND empresa="'.$empresas[0].'" ')->all();

        $list_dependencia=ArrayHelper::map($dependencias,'codigo','nombre');


        $tipo_inv=TipoInvitado::find()->where('nit_empresa='.$empresas[0])->all();
        $list_inv=ArrayHelper::map($tipo_inv,'id','nombre');

        $tipo_obs=TipoObservacion::find()->where('nit_empresa='.$empresas[0])->all();
        $list_obs=ArrayHelper::map($tipo_obs,'id','nombre');


        $puestos=PuestosDependencia::find()->all();
        $list_puestos=ArrayHelper::map($puestos,'nombre','nombre');  




        $list_personas=$personas->find()->all();
        $array_personas=[];

        foreach ($list_personas as $person) {
          $array_personas[$person->cedula]= $person->nombres." ".$person->apellidos;         
        }  
        //print_r($array_personas);
          

        if ($model->load(Yii::$app->request->post()) ) {
            $model->setAttribute('fecha', $_POST['fecha']);
            $model->setAttribute('usuario', Yii::$app->session['usuario-exito']);
            $model->setAttribute('area_dependencia', $_POST['area_dependencia']);
            $model->setAttribute('codigo_dependencia', $_POST['MinutaHumana']['codigo_dependencia']);
            

            if($model->save()){
            //return $this->redirect(['view', 'id' => $model->id]);
              Yii::$app->session->setFlash('success','Ingreso creado correctamente');
              return $this->redirect(['create']);
            }else{

              print_r($model->getErrors());    
            }

        } else {
           // print_r($model->getErrors());        
            //PAGINACION
             $page=0;$rowsPerPage=10;
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


            ////////////
            $permisos = array();
            if( isset(Yii::$app->session['permisos-exito']) ){
              $permisos = Yii::$app->session['permisos-exito'];
            }
            

             $rows = (new \yii\db\Query())
             ->select(['m.id','m.cedula_persona','m.hora_entrada','m.hora_salida','m.fecha','emp.nombre empresa','u.usuario','CONCAT(p.nombres, " ", p.apellidos) Persona','cc.nombre dependencia','ti.nombre tipo_invitado','to.nombre tipo_observacion','m.observacion','m.puesto','m.observacion_salida'])
             ->from('minuta_humana m')
             ->leftJoin('tipo_invitado ti', 'm.tipo_invitado = ti.id')
             ->leftJoin('tipo_observacion to', 'm.tipo_observacion = to.id')
             ->leftJoin('empresa emp', 'm.nit_empresa = emp.nit')
             ->leftJoin('personas p', 'm.cedula_persona = p.cedula')
             ->leftJoin('usuario u', 'm.usuario = u.usuario')
             ->leftJoin('centro_costo cc', 'm.codigo_dependencia = cc.codigo')
             ->where('m.fecha="'.date('Y-m-d').'" ');


            if (!in_array("administrador", $permisos)) {
              $rows->andWhere('(cc.codigo '.$in_final.') and (cc.empresa="'.$empresas[0].'" )');
            }

            if(isset($_POST['buscar'])){
                if (trim($_POST['buscar'])!='') {
                    $buscar=trim($_POST['buscar']);

                    // $rows->andWhere("m.cedula_persona like '%". $buscar."%' OR p.nombres like '%".$buscar."%' OR p.apellidos like '%".$buscar."%' ");

                    $rows->andWhere("m.cedula_persona = '". $buscar."' OR p.nombres like '%".$buscar."%' OR p.apellidos like '%".$buscar."%' ");
                }

            }


            $rows->groupBy('m.cedula_persona');
            $rowsCount= clone $rows;

            $ordenado='m.id';
            $rows->orderBy([$ordenado => SORT_DESC]);



            $rows->limit($rowsPerPage)->offset($start);

            $command = $rows->createCommand();
            //echo $command->sql;exit();
            $query = $command->queryAll();

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
                    'modelcount' => $modelcount,
                    'model'=>$model
                    
                ), true);
            }

             $res.= $this->renderPartial('_partial', array(
            'query' => $query,
            'modelcount' => $modelcount,
            'model'=>$model
    
                ), true);

            if(isset($_POST['page'])){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'respuesta' => $res,
                    'query' => $command->sql,
                ];
            }else{

                

                return $this->render('create', [
                    'partial' => $res,
                    'model' => $model,
                    'list_inv'=>$list_inv,
                    'list_obs'=>$list_obs,
                    'empresas'=>$empresas,
                    'personas'=>$personas,
                    'list_dependencia'=>$list_dependencia,
                    'areas'=>$areas,
                    'list_puestos'=>$list_puestos,
                    'array_personas'=>$array_personas
                ]);
            }
        }
    }


    public function dependencias_usuario($id){

        $usuario= Usuario::findOne($id);
        $zonasUsuario     = array();
        //$marcasUsuario    = array();
        $distritosUsuario = array();
        $dependencias     = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();

        if ($usuario != null) {

            $zonasUsuario     = $usuario->zonas;
           // $marcasUsuario    = $usuario->marcas;
            $distritosUsuario = $usuario->distritos;

        }


        $ciudades_zonas = array();

            foreach($zonasUsuario as $zona){
                
                 $ciudades_zonas [] = $zona->zona->ciudades;    
                
            }

            $ciudades_permitidas = array();

            foreach($ciudades_zonas as $ciudades){
                
                foreach($ciudades as $ciudad){
                    
                    $ciudades_permitidas [] = $ciudad->ciudad->codigo_dane;
                    
                }
                
            }

            // $marcas_permitidas = array();

            // foreach($marcasUsuario as $marca){
                
                    
            //         $marcas_permitidas [] = $marca->marca_id;

            // }

            $dependencias_distritos = array();

            foreach($distritosUsuario as $distrito){
                
                 $dependencias_distritos [] = $distrito->distrito->dependencias;    
                
            }

            $dependencias_permitidas = array();

            foreach($dependencias_distritos as $dependencias0){
                
                foreach($dependencias0 as $dependencia0){
                    
                    $dependencias_permitidas [] = $dependencia0->dependencia->codigo;
                    
                }
                
            }


            foreach($dependencias as $value){
    
                if(in_array($value->ciudad_codigo_dane,$ciudades_permitidas)){
                    
                    //if(in_array($value->marca_id,$marcas_permitidas)){
                        
                       if($tamano_dependencias_permitidas > 0){
                           
                           if(in_array($value->codigo,$dependencias_permitidas)){
                               
                             $data_dependencias[$value->codigo] =  $value->nombre;
                               
                           }else{
                               //temporal mientras se asocian distritos
                               $data_dependencias[] =  $value->codigo;
                           }
                           
                           
                       }else{
                           
                           $data_dependencias[] =  $value->codigo;
                       }    
                   
                    //}

                }
            }
            return $data_dependencias;



    }




    public function actionSalida($id){
      date_default_timezone_set ( 'America/Bogota');
      $model = $this->findModel($id);
      ///echo $id;
      $model->setAttribute('hora_salida', $_POST['hora']);
      $model->setAttribute('observacion_salida',$_POST['obs_salida']);
      $model->save();
      //print_r($model->getErrors());
      Yii::$app->session->setFlash('success','Salida Correcta');
      return $this->redirect(['create']);
    }

    public function actionPersona(){

        $cedula=$_POST['cedula'];

        $query=Personas::find()->where('cedula="'.$cedula.'" ')->one();

        $data=array();
        if ($query!=null) {
            $data['respuesta']=1;
            $data['persona']=$query->nombres." ".$query->apellidos;
            $data['estado']=$query->estado;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return $data;
        }else{

            $data['respuesta']=0;

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return $data;

        }


    }


    public function actionCrear_persona(){
      $model = new Personas();
      
      $data=array();

      if ($model->load(Yii::$app->request->post()) ) {
           if($model->validate())
            {
              if($model->save()){
                $data['respuesta']=1;
                $data['error']=0;
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $data;
              }
            }
            else
            { 
              $data['respuesta']=0;
              $data['error']=  $model->getErrors();
              \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
              return $data;
            }
      } 

    }
    /**
     * Updates an existing MinutaHumana model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    { 
        $id=$_POST['id'];
        $model = $this->findModel($id);
        $tipo_inv=TipoInvitado::find()->all();
        $list_inv=ArrayHelper::map($tipo_inv,'id','nombre');

        $tipo_obs=TipoObservacion::find()->all();
        $list_obs=ArrayHelper::map($tipo_obs,'id','nombre');

        $usuario = Usuario::findOne(Yii::$app->session['usuario-exito']);

        $empresas = array();
        if($usuario != null){
         
          $empresasUsuario = $usuario->empresas;

          foreach ($empresasUsuario as $value) {

            $sql=Empresa::find()->where('nit="'.$value->nit.'"')->one();
            $empresas[$value->nit]=$sql->nombre;
          }

          // echo "<pre>";
          // print_r($empresas);
          // echo "</pre>";
        }



        if ($model->load(Yii::$app->request->post())) {

            $model->setAttribute('hora_entrada', $_POST['MinutaHumana']['hora_entrada']);
            $model->setAttribute('hora_salida', $_POST['MinutaHumana']['hora_salida']);

            $model->save();
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['create']);
        } else {
             $res=$this->renderPartial('_form', [
                'model' => $model,
                'list_inv'=>$list_inv,
                'list_obs'=>$list_obs,
                'empresas'=>$empresas,
                'actualizar'=>1
            ]);

             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'respuesta' => $res,
                
            ];
        }
    }

    /**
     * Deletes an existing MinutaHumana model.
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
     * Finds the MinutaHumana model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MinutaHumana the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MinutaHumana::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
