<?php

namespace app\controllers;

use app\models\CapacitacionDependencia;
use app\models\CentroCosto;
use app\models\CentroDistrito;
use app\models\Ciudad;
use app\models\ComiteDependencia;
use app\models\DetalleServicio;
use app\models\Dia;
use app\models\Distrito;
use app\models\Empresa;
use app\models\Evento;
use app\models\Jornada;
use app\models\Marca;
use app\models\ModeloPrefactura;
use app\models\PrefacturaFija;
use app\models\Presupuesto;
use app\models\Puesto;
use app\models\Responsable;
use app\models\Siniestro;
use app\models\Usuario;
use app\models\VisitaDia;
use app\models\VisitaMensual;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

class CentroCostoController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'Capacitacion', 'Comite', 'Prefacturas', 'DeleteRenglon', 'Modelo',
                		    'Puestos', 'Siniestro', 'Visita', 'Mensual', 'Evento', 'Informacion',
                		    'Imagen', 'view', 'update', 'create', 'delete', 'DeleteImagen'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'Capacitacion', 'Comite', 'Prefacturas', 'DeleteRenglon', 'Modelo',
                            		  'Puestos', 'Siniestro', 'Visita', 'Mensual', 'Evento', 'Informacion',
                            		  'Imagen', 'view', 'update', 'create', 'delete', 'DeleteImagen'],
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

    public function actionIndex(){
        Yii::$app->session->setTimeout(5400);
        //$roles = Yii::$app->session['rol-exito'];

        /* Yii::$app->mailer->compose()
        ->setFrom('sgsexito@cvsc.com.co')
        ->setTo('olsalas@uninorte.edu.co')
        ->setSubject('Prueba')
        ->setTextBody('Plain text content')
        ->setHtmlBody('<h1>Es una Prueba</h1>')
        ->send();*/

        $usuario          = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $zonasUsuario     = array();
        $marcasUsuario    = array();
        $distritosUsuario = array();

        if ($usuario != null) {

            $zonasUsuario     = $usuario->zonas;
            $marcasUsuario    = $usuario->marcas;
            $distritosUsuario = $usuario->distritos;

        }

        $roles = Yii::$app->session['rol-exito'];

        if ($roles != null) {

            if (in_array("administrador", $roles)) {

                $dependencias = CentroCosto::find()->orderBy(['nombre' => SORT_ASC])->all();

            } else {

                $dependencias = CentroCosto::find()->where(['not in', 'estado', ['C']])->orderBy(['nombre' => SORT_ASC])->all();

            }

        }

        return $this->render('index', [
            'dependencias'     => $dependencias,
            'zonasUsuario'     => $zonasUsuario,
            'marcasUsuario'    => $marcasUsuario,
            'distritosUsuario' => $distritosUsuario,

        ]);
    }

    public function actionCapacitacion($id)
    {
        Yii::$app->session->setTimeout(5400);
        $roles = Yii::$app->session['rol-exito'];

        $capacitaciones = CapacitacionDependencia::find()->where(['centro_costo_codigo' => $id])
            ->orderBy(['capacitacion_id' => SORT_DESC])->all();

        return $this->render('capacitacion', [
            'capacitaciones'     => $capacitaciones,
            'codigo_dependencia' => $id,
            'capacitacion'       => 'active',

        ]);
    }

    public function actionComite($id)
    {
        Yii::$app->session->setTimeout(5400);
        $roles = Yii::$app->session['rol-exito'];

        $comites = ComiteDependencia::find()->where(['centro_costo_codigo' => $id])
            ->orderBy(['comite_id' => SORT_DESC])->all();

        return $this->render('comite', [
            'comites'            => $comites,
            'codigo_dependencia' => $id,
            'comite'             => 'active',

        ]);
    }

    public function actionPrefacturas($id)
    {
        Yii::$app->session->setTimeout(5400);
        $roles = Yii::$app->session['rol-exito'];

        $prefacturas = PrefacturaFija::find()->where(['centro_costo_codigo' => $id])
            ->orderBy(['ano' => SORT_DESC, 'mes' => SORT_DESC])->all();

        return $this->render('prefactura', [

            'prefacturas'        => $prefacturas,
            'codigo_dependencia' => $id,
            'modelo_prefactura'  => 'active',

        ]);
    }

    public function actionDeleteRenglon($id, $dependencia)
    {
        $model = ModeloPrefactura::findOne($id);

        if ($model != null) {

            $model->delete();
        }

        return $this->redirect(['modelo', 'id' => $dependencia]);
    }

    public function actionModelo($id){
        //$this->layout = 'main_sin_menu';
        Yii::$app->session->setTimeout(5400);
        //obtener filas del modelo de prefactura
        $filas_modelo = ModeloPrefactura::find()->where(['centro_costo_codigo' => $id])->orderBy(['detalle_servicio_id' => SORT_ASC, 'puesto_id' => SORT_ASC])->all();

        return $this->render('modelo', [
            'codigo_dependencia' => $id,
            'modelo_prefactura'  => 'active',
            'filas_modelo'       => $filas_modelo,

        ]);
    }

    public function actionPuestos()
    {

        $out      = [];
        $servicio = '3';
        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                $servicio = $parents[0];

                $puestos = Puesto::find()->where(['servicio_id' => $servicio])
                    ->all();

                $data         = array();
                $defaultValue = '';

                foreach ($puestos as $key) {

                    $data[]       = array('id' => $key->id, 'name' => $key->nombre);
                    $defaultValue = $key->id;
                }

                $value = (count($data) === 0) ? ['' => ''] : $data;

                $out = $value;

                echo Json::encode(['output' => $out]);
                return;
            }

        }

        echo Json::encode(['output' => '', 'selected' => '']);

    }

    public function actionSiniestro($id)
    {
        Yii::$app->session->setTimeout(5400);
        $roles = Yii::$app->session['rol-exito'];

        $siniestros = Siniestro::find()->where(['centro_costo_codigo' => $id])
            ->orderBy(['id' => SORT_DESC])->all();

        return $this->render('siniestro', [
            'siniestros'         => $siniestros,
            'codigo_dependencia' => $id,
            'siniestro'          => 'active',

        ]);
    }

    public function actionVisita($id)
    {
        Yii::$app->session->setTimeout(5400);
        $roles = Yii::$app->session['rol-exito'];

        $visitas = VisitaDia::find()->where(['centro_costo_codigo' => $id])
            ->orderBy(['id' => SORT_DESC])->all();

        return $this->render('visita', [
            'visitas'            => $visitas,
            'codigo_dependencia' => $id,
            'visita'             => 'active',

        ]);
    }

    public function actionMensual($id)
    {
        Yii::$app->session->setTimeout(5400);
        $roles   = Yii::$app->session['rol-exito'];
        $visitas = VisitaMensual::find()->where(['centro_costo_codigo' => $id])
            ->orderBy(['id' => SORT_DESC])->all();
        return $this->render('mensual', [
            'visitas'            => $visitas,
            'codigo_dependencia' => $id,
            'visita'             => 'active',
        ]);
    }
    public function actionEvento($id)
    {
        Yii::$app->session->setTimeout(5400);
        $roles = Yii::$app->session['rol-exito'];

        $visitas = Evento::find()->where(['centro_costo_codigo' => $id])
            ->orderBy(['id' => SORT_DESC])->all();

        return $this->render('evento', [
            'visitas'            => $visitas,
            'codigo_dependencia' => $id,
            'visita'             => 'active',

        ]);
    }

    public function actionInformacion($id)
    {
        Yii::$app->session->setTimeout(5400);
        $roles = Yii::$app->session['rol-exito'];

        $responsables = Responsable::find()->where(['centro_costo_codigo' => $id])
            ->orderBy(['nombre' => SORT_DESC])->all();

        return $this->render('informacion', [
            'responsables'       => $responsables,
            'codigo_dependencia' => $id,
            'informacion'        => 'active',
            'model'              => $this->findModel($id),

        ]);
    }

    public function actionImagen($id)
    {
        Yii::$app->session->setTimeout(5400);
        $roles                          = Yii::$app->session['rol-exito'];
        $array_post                     = Yii::$app->request->post();
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
        $shortPath                      = '/uploads/';
        $model                          = $this->findModel($id);

        if (isset($array_post['cambiar'])) {

            $image = UploadedFile::getInstance($model, 'image');
            if ($image !== null) {
                date_default_timezone_set('America/Bogota');
                $fecha_registro = date('Ymd', time());

                $model->foto = $fecha_registro . '_' . utf8_encode($image->name);
                $ext         = end((explode(".", $image->name)));
                $path        = Yii::$app->params['uploadPath'] . $model->foto;
                $model->foto = $shortPath . $model->foto;
                $model->save();
                $image->saveAs($path);

                return $this->redirect(['informacion', 'id' => $id]);

            }

        }

        return $this->render('imagen', [
            'model'              => $model,
            'codigo_dependencia' => $id,
            //'visita' => 'active',

        ]);
    }

    /**
     * Displays a single CentroCosto model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CentroCosto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->session->setTimeout(5400);
        $roles = Yii::$app->session['rol-exito'];

        $marcas     = Marca::find()->orderBy(['nombre' => SORT_ASC])->all();
        $ciudades   = Ciudad::find()->orderBy(['nombre' => SORT_ASC])->all();
        $distritos  = Distrito::find()->orderBy(['nombre' => SORT_ASC])->all();
        $empresas   = Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();
        $array_post = Yii::$app->request->post();
        $model      = new CentroCosto();

        $usuario          = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $zonasUsuario     = array();
        $marcasUsuario    = array();
        $distritosUsuario = array();

        if ($usuario != null) {

            $zonasUsuario     = $usuario->zonas;
            $marcasUsuario    = $usuario->marcas;
            $distritosUsuario = $usuario->distritos;

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $distrito = array_key_exists('distrito', $array_post) ? $array_post['distrito'] : '';

            if ($distrito != '') {

                $model_r = new CentroDistrito();
                $model_r->setAttribute('distrito_id', $distrito);
                $model_r->setAttribute('centro_costo_codigo', $model->codigo);
                $model_r->save();

            }
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model'            => $model,
                'marcas'           => $marcas,
                'ciudades'         => $ciudades,
                'distritos'        => $distritos,
                'zonasUsuario'     => $zonasUsuario,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'empresas'         => $empresas,
            ]);
        }
    }

    /**
     * Updates an existing CentroCosto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        Yii::$app->session->setTimeout(5400);
        $roles    = Yii::$app->session['rol-exito'];
        $empresas = Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();

        $model            = $this->findModel($id);
        $array_post       = Yii::$app->request->post();
        $marcas           = Marca::find()->orderBy(['nombre' => SORT_ASC])->all();
        $ciudades         = Ciudad::find()->orderBy(['nombre' => SORT_ASC])->all();
        $distritos        = Distrito::find()->orderBy(['nombre' => SORT_ASC])->all();
        $usuario          = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $zonasUsuario     = array();
        $marcasUsuario    = array();
        $distritosUsuario = array();

        if ($usuario != null) {

            $zonasUsuario     = $usuario->zonas;
            $marcasUsuario    = $usuario->marcas;
            $distritosUsuario = $usuario->distritos;

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $distrito = array_key_exists('distrito', $array_post) ? $array_post['distrito'] : '';

            $presupuesto = Presupuesto::find()->where(['centro_costo_codigo' => $model->codigo])->one();

            if ($presupuesto != null) {

                $presupuesto->setAttribute('estado_dependencia', $model->estado);
                $presupuesto->save();

            }

            if ($distrito != '') {

                $primaryConnection = Yii::$app->db;
                $primaryCommand    = $primaryConnection->createCommand("DELETE
    				FROM centro_distrito
    				WHERE centro_costo_codigo = :centro
    				");
                $primaryCommand->bindValue(':centro', $model->codigo)->execute();

                $model_r = new CentroDistrito();
                $model_r->setAttribute('distrito_id', $distrito);
                $model_r->setAttribute('centro_costo_codigo', $model->codigo);
                $model_r->save();

            }

            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model'            => $model,
                'marcas'           => $marcas,
                'ciudades'         => $ciudades,
                'distritos'        => $distritos,
                'zonasUsuario'     => $zonasUsuario,
                'marcasUsuario'    => $marcasUsuario,
                'distritosUsuario' => $distritosUsuario,
                'empresas'         => $empresas,
            ]);
        }
    }

    /**
     * Deletes an existing CentroCosto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteImagen($id)
    {

        /*Server bluehost*/
		//$prefijo = '/home/cvsccomc/public_html/sgs/web';

        /*Servidor Local*/
        $prefijo = Yii::getAlias('@web');

        $model = $this->findModel($id);

        $name = ($model->foto == null) ? '' : $model->foto;

        $filename = $prefijo . $name;

        if (file_exists($filename)) {

            unlink($filename);
        }

        $model->setAttribute('foto', null);

        $model->save();

        return $this->redirect(['informacion', 'id' => $id]);
    }
    public function actionCreateModelo($id)
    {
        $this->layout = 'main_sin_menu';
        Yii::$app->session->setTimeout(5400);
        $array_post = Yii::$app->request->post();
        $roles      = Yii::$app->session['rol-exito'];
        $model      = new ModeloPrefactura();
        date_default_timezone_set ( 'America/Bogota');
        $year = date('Y',time());
        $servicios  = DetalleServicio::find()->where("ano='".$year."'")->orderBy(['codigo' => SORT_ASC])->all();
        $puesto  = Puesto::find()->all();
        $jornada  = Jornada::find()->all();

        if (isset($array_post) && array_key_exists('hora_fin2', $array_post)) {
            $cantidad = $array_post['ModeloPrefactura']['cantidad_servicios'];
            $detalle_servicio  = $array_post['ModeloPrefactura']['detalle_servicio_id'];
            //echo $array_post['ModeloPrefactura']['cantidad_servicios'];exit();
            //print_r($array_post);
            //echo "aqui".$cantidad;exit();
            if ($detalle_servicio != 0) {
                //guardar filas
                $modelo_prefactura = new ModeloPrefactura();
                $puesto = $array_post['ModeloPrefactura']['puesto_id'];
                $can_servicio = $array_post['ModeloPrefactura']['cantidad_servicios'];
                $jornada = $array_post['ModeloPrefactura']['horas'];
                $desde = $array_post['ModeloPrefactura']['hora_inicio'];
                $hasta = $array_post['hora_fin2'];
                $porcentaje = $array_post['ModeloPrefactura']['porcentaje'];
                $ftes = $array_post['ftes2'];
                $dias_totales = $array_post['dias_prestados2'];
                $precio = $array_post['valor_servicio2'];

                $lunes = $array_post['ModeloPrefactura']['lunes'];
                $martes = $array_post['ModeloPrefactura']['martes'];
                $miercoles = $array_post['ModeloPrefactura']['miercoles'];
                $jueves = $array_post['ModeloPrefactura']['jueves'];
                $viernes = $array_post['ModeloPrefactura']['viernes'];
                $sabado = $array_post['ModeloPrefactura']['sabado'];
                $domingo = $array_post['ModeloPrefactura']['domingo'];
                $festivo = $array_post['ModeloPrefactura']['festivo'];
                if ($lunes == '1') {
                    $modelo_prefactura->setAttribute('lunes', 'X');
                }
                if ($martes == '1') {
                    $modelo_prefactura->setAttribute('martes', 'X');
                }
                if ($miercoles == '1') {
                    $modelo_prefactura->setAttribute('miercoles', 'X');
                }
                if ($jueves == '1') {
                    $modelo_prefactura->setAttribute('jueves', 'X');
                }
                if ($viernes == '1') {
                    $modelo_prefactura->setAttribute('viernes', 'X');
                }
                if ($sabado == '1') {
                    $modelo_prefactura->setAttribute('sabado', 'X');
                }
                if ($domingo == '1') {
                    $modelo_prefactura->setAttribute('domingo', 'X');
                }
                if ($festivo == '1') {
                    $modelo_prefactura->setAttribute('festivo', 'X');
                }
                $modelo_prefactura->setAttribute('detalle_servicio_id', $detalle_servicio);
                $modelo_prefactura->setAttribute('puesto_id', $puesto);
                $modelo_prefactura->setAttribute('cantidad_servicios', $can_servicio);
                $modelo_prefactura->setAttribute('horas', $jornada);
                $modelo_prefactura->setAttribute('hora_inicio', $desde);
                $modelo_prefactura->setAttribute('hora_fin', $hasta);
                $modelo_prefactura->setAttribute('porcentaje', $porcentaje);
                $modelo_prefactura->setAttribute('ftes', $ftes);
                $modelo_prefactura->setAttribute('total_dias', $dias_totales);
                $modelo_prefactura->setAttribute('valor_mes', $precio);
                $modelo_prefactura->setAttribute('centro_costo_codigo', $id);
                if($modelo_prefactura->save()){
                    return $this->redirect(['modelo', 'id' => $id]);
                }else{
                    print_r($modelo_prefactura->getErrors());
                }
            }
        }else{
            return $this->render('modelo_create', [
                'codigo_dependencia' => $id,
                'servicios'          => $servicios,
                'puesto'          => $puesto,
                'modelo_prefactura'  => 'active',
                'model'              => $model,
                'jornada'              => $jornada,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = CentroCosto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
