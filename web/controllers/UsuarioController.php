<?php

namespace app\controllers;

use app\models\Capacitacion;
use app\models\Ciudad;
use app\models\Comite;
use app\models\Distrito;
use app\models\Empresa;
use app\models\Evento;
use app\models\Incidente;
use app\models\Macroactividad;
use app\models\Marca;
use app\models\Merma;
use app\models\Microactividad;
use app\models\Rol;
use app\models\RolUsuario;
use app\models\Siniestro;
use app\models\Usuario;
use app\models\UsuarioDistrito;
use app\models\UsuarioEmpresa;
use app\models\UsuarioMacroactividad;
use app\models\UsuarioMarca;
use app\models\UsuarioMicroactividad;
use app\models\UsuarioZona;
use app\models\VisitaDia;
use app\models\VisitaMensual;
use app\models\Zona;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'Cordinadores', 'CordinadoresTorta', 'DeleteMacro', 'DeleteMicro', 'View', 'Create', 'Update', 'Delete', 
                            'ActividadesMacro', 'ActividadesMicro', 'Capacitacion', 'Comite', 'Siniestro', 'Visita', 'Incidente', 'Merma', 
                            'Evento', 'Mensual', ],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'Cordinadores', 'CordinadoresTorta', 'DeleteMacro', 'DeleteMicro', 'View', 'Create', 'Update', 'Delete', 
                                      'ActividadesMacro', 'ActividadesMicro', 'Capacitacion', 'Comite', 'Siniestro', 'Visita', 'Incidente', 'Merma', 
                                      'Evento', 'Mensual', ],
                        'roles'   => ['@'], //para usuarios logueados
                    ],
                ],  
            ],
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {

        $roles = Yii::$app->session['rol-exito'];

        $usuarios = Usuario::find()->orderBy(['apellidos' => SORT_ASC])->all();

        return $this->render('index', [
            'usuarios' => $usuarios,

        ]);
    }

    public function actionCordinadores()
    {

        $array_post = Yii::$app->request->post();

        $primaryConnection = Yii::$app->db;

        $sql = '';

        $parametros_array = array();

        if (array_key_exists('consultar', $array_post)) {

            if (array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)) {

                if ($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != '') {

                    $sql .= ' AND c.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY) ';

                    $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                    $parametros_array[':FECHA_2'] = $array_post['fecha_final'];

                }

            }

        }

        $capacitaciones_zonas_sql = "SELECT COUNT(*) AS TOTAL, z.nombre AS REGIONAL
                                        FROM capacitacion c, usuario_zona uz, zona z
                                        WHERE  c.usuario = uz.usuario
                                        AND   uz.zona_id = z.id
                                        AND   c.usuario NOT IN ('admin','miguel guevara')" . $sql . "
                                        GROUP BY z.nombre";

        $comites_zonas_sql = "SELECT COUNT(*) AS TOTAL, z.nombre AS REGIONAL
                                FROM comite c, usuario_zona uz, zona z
                                WHERE  c.usuario = uz.usuario
                                AND   uz.zona_id = z.id
                                AND   c.usuario NOT IN ('admin','miguel guevara')" . $sql . "
                                GROUP BY z.nombre";

        $visitas_zonas_sql = "SELECT COUNT(*) AS TOTAL, z.nombre AS REGIONAL
                                FROM visita_dia c, usuario_zona uz, zona z
                                WHERE  c.usuario = uz.usuario
                                AND   uz.zona_id = z.id
                                AND   c.usuario NOT IN ('admin','miguel guevara')" . $sql . "
                                GROUP BY z.nombre";

        $visitas_mensuales_zonas_sql = "SELECT COUNT(*) AS TOTAL, z.nombre AS REGIONAL
                                FROM visita_mensual c, usuario_zona uz, zona z
                                WHERE  c.usuario = uz.usuario
                                AND   uz.zona_id = z.id
                                AND   c.usuario NOT IN ('admin','miguel guevara')" . $sql . "
                                GROUP BY z.nombre";

        $siniestros_zonas_sql = "SELECT COUNT(*) AS TOTAL, z.nombre AS REGIONAL
                                FROM siniestro c, usuario_zona uz, zona z
                                WHERE  c.usuario = uz.usuario
                                AND   uz.zona_id = z.id
                                AND   c.usuario NOT IN ('admin','miguel guevara')" . $sql . "
                                GROUP BY z.nombre";

        $incidentes_zonas_sql = "SELECT COUNT(*) AS TOTAL, z.nombre AS REGIONAL
                                        FROM incidente c, usuario_zona uz, zona z
                                        WHERE  c.usuario = uz.usuario
                                        AND   uz.zona_id = z.id
                                        AND   c.usuario NOT IN ('admin','miguel guevara')" . $sql . "
                                        GROUP BY z.nombre";

        $capacitacionesCommand = $primaryConnection->createCommand($capacitaciones_zonas_sql);
        $comitesCommand        = $primaryConnection->createCommand($comites_zonas_sql);
        $visitasCommand        = $primaryConnection->createCommand($visitas_zonas_sql);
        $siniestrosCommand     = $primaryConnection->createCommand($siniestros_zonas_sql);
        $incidentesCommand     = $primaryConnection->createCommand($incidentes_zonas_sql);

        if (array_key_exists('consultar', $array_post)) {

            $consolidadoCapacitaciones = $capacitacionesCommand->bindValues($parametros_array)->queryAll();

            $consolidadoComites = $comitesCommand->bindValues($parametros_array)->queryAll();

            $consolidadoVisitas = $visitasCommand->bindValues($parametros_array)->queryAll();

            $consolidadoSiniestros = $siniestrosCommand->bindValues($parametros_array)->queryAll();

            $consolidadoIncidentes = $incidentesCommand->bindValues($parametros_array)->queryAll();
        } else {

            $consolidadoCapacitaciones = $capacitacionesCommand->queryAll();

            $consolidadoComites = $comitesCommand->queryAll();

            $consolidadoVisitas = $visitasCommand->queryAll();

            $consolidadoSiniestros = $siniestrosCommand->queryAll();

            $consolidadoIncidentes = $incidentesCommand->queryAll();

        }

        $roles       = Yii::$app->session['rol-exito'];
        $active_user = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $usuarios    = Usuario::find()->orderBy(['apellidos' => SORT_ASC])->all();

        return $this->render('cordinadores', [
            'usuarios'                  => $usuarios,
            'active_user'               => $active_user,
            'consolidadoCapacitaciones' => $consolidadoCapacitaciones,
            'consolidadoComites'        => $consolidadoComites,
            'consolidadoVisitas'        => $consolidadoVisitas,
            'consolidadoSiniestros'     => $consolidadoSiniestros,
            'consolidadoIncidentes'     => $consolidadoSiniestros,
        ]);
    }

    public function actionCordinadoresTorta()
    {

        $regionales = Zona::find()->orderBy(['nombre' => SORT_ASC])->all();

        $array_post = Yii::$app->request->post();

        $primaryConnection = Yii::$app->db;

        $sql = '';

        $parametros_array = array();

        if (array_key_exists('consultar', $array_post)) {

            if (array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)) {

                if ($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != '') {

                    $sql .= ' AND c.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY) ';

                    $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                    $parametros_array[':FECHA_2'] = $array_post['fecha_final'];

                }

            }

        }

        $capacitaciones_zonas_sql = "SELECT COUNT(*) AS TOTAL, z.nombre AS REGIONAL, n.nombre AS TEMA
                                        FROM capacitacion c, usuario_zona uz, zona z, novedad n
                                        WHERE  c.usuario = uz.usuario
                                        AND   uz.zona_id = z.id
                                        AND   c.usuario NOT IN ('admin','miguel guevara')
                                        AND   c.novedad_id = n.id
                                        AND   n.tipo = 'C'
                                        AND   z.id = :regional" . $sql . "
                                        GROUP BY z.nombre, n.nombre";

        $capacitacionesCommand = $primaryConnection->createCommand($capacitaciones_zonas_sql);

        if (array_key_exists('consultar', $array_post)) {

            $parametros_array[':regional'] = $array_post['regional'];
            $consolidadoCapacitaciones     = $capacitacionesCommand->bindValues($parametros_array)->queryAll();
            $selected                      = $array_post['regional'];

        } else {

            $consolidadoCapacitaciones = $capacitacionesCommand->bindValue(':regional', $regionales[0]->id)->queryAll();
            $selected                  = $regionales[0]->id;
        }

        $active_user = Usuario::findOne(Yii::$app->session['usuario-exito']);
        $usuarios    = Usuario::find()->orderBy(['apellidos' => SORT_ASC])->all();

        return $this->render('torta', [
            'usuarios'                  => $usuarios,
            'active_user'               => $active_user,
            'consolidadoCapacitaciones' => $consolidadoCapacitaciones,
            'regionales'                => $regionales,
            'selected'                  => $selected,

        ]);
    }

    public function actionDeleteMacro($id, $macro)
    {

        $primaryConnection = Yii::$app->db;
        $primaryCommand    = $primaryConnection->createCommand("DELETE
                                                             FROM  usuario_macroactividad
                                                             WHERE usuario = :usuario
                                                             AND   macroactividad_id = :macro
                                                             ");

        $borrado = $primaryCommand->bindValue(':usuario', $id)
            ->bindValue(':macro', $macro)
            ->execute();

        return $this->redirect(Yii::$app->request->baseUrl . '/usuario/actividades-macro?id=' . $id);

    }

    public function actionDeleteMicro($id, $micro)
    {

        $primaryConnection = Yii::$app->db;
        $primaryCommand    = $primaryConnection->createCommand("DELETE
                                                             FROM  usuario_microactividad
                                                             WHERE usuario = :usuario
                                                             AND   microactividad_id = :micro
                                                             ");

        $borrado = $primaryCommand->bindValue(':usuario', $id)
            ->bindValue(':micro', $micro)
            ->execute();

        return $this->redirect(Yii::$app->request->baseUrl . '/usuario/actividades-micro?id=' . $id);

    }

    //$id usuario
    public function actionActividadesMacro($id)
    {

        $array_post = Yii::$app->request->post();

        $macroactividades_asignadas = UsuarioMacroactividad::find()->where(['usuario' => $id])->all();
        $usuario                    = $this->findModel($id);

        $asignaciones_macro = array_key_exists('macroactividades-asi', $array_post) ? $array_post['macroactividades-asi'] : array();

        $tamano_asignaciones_macro = count($asignaciones_macro);

        $index = 0;

        while ($index < $tamano_asignaciones_macro) {

            $model = new UsuarioMacroactividad();
            $model->SetAttribute('macroactividad_id', $asignaciones_macro[$index]);
            $model->SetAttribute('usuario', $id);
            $model->save();
            $index++;

        }

        if ($tamano_asignaciones_macro > 0) {

            return $this->redirect('index');

        }

        $macroactividades = Macroactividad::find()->orderBy(['nombre' => SORT_ASC])->all();

        return $this->render('macroactividades', ['usuario' => $usuario, 'macroactividades_asignadas' => $macroactividades_asignadas, 'macroactividades' => $macroactividades]);

    }

    public function actionActividadesMicro($id)
    {

        $array_post = Yii::$app->request->post();

        $microactividades_asignadas = UsuarioMicroactividad::find()->where(['usuario' => $id])->all();
        $usuario                    = $this->findModel($id);

        $asignaciones_micro = array_key_exists('microactividades-asi', $array_post) ? $array_post['microactividades-asi'] : array();

        $tamano_asignaciones_micro = count($asignaciones_micro);

        $index = 0;

        while ($index < $tamano_asignaciones_micro) {

            $model = new UsuarioMicroactividad();
            $model->SetAttribute('microactividad_id', $asignaciones_micro[$index]);
            $model->SetAttribute('usuario', $id);
            $model->save();
            $index++;

        }

        if ($tamano_asignaciones_micro > 0) {

            return $this->redirect('index');

        }

        $microactividades = Microactividad::find()->orderBy(['nombre' => SORT_ASC])->all();

        return $this->render('microactividades', ['usuario' => $usuario, 'microactividades_asignadas' => $microactividades_asignadas, 'microactividades' => $microactividades]);

    }

    public function actionCapacitacion($id)
    {

        //obtener objeto usuario
        $usuarioObj        = Usuario::findOne($id);
        $roles             = array();
        $regional          = false;
        $array_post        = Yii::$app->request->post();
        $primaryConnection = Yii::$app->db;

        if ($usuarioObj != null) {

            $roles = $usuarioObj->roles;

            if ($roles != null) {

                foreach ($roles as $rol) {

                    if ($rol->rol->nombre == 'Coordinador Regional') {

                        $regional = true;
                        break;

                    }

                }

            }

        }

        $consolidadoCoordinadores = array();
        $consolidadoTemas         = array();

        if ($regional) {

            $zonasObj = $usuarioObj->zonas;

            if ($zonasObj != null) {

                foreach ($zonasObj as $zona) {

                    $usuarios    = $zona->zona->usuarios;
                    $regional_id = $zona->zona_id;

                    $sql = '';

                    $parametros_array = array();

                    if (array_key_exists('consultar', $array_post)) {

                        if (array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)) {

                            if ($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != '') {

                                $sql .= ' AND c.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY) ';

                                $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                                $parametros_array[':FECHA_2'] = $array_post['fecha_final'];

                            }

                        }

                    }

                    $regionalSql = "SELECT COUNT(*) AS TOTAL, uz.usuario AS USER
                                        FROM capacitacion c, usuario_zona uz
                                        WHERE  c.usuario = uz.usuario
                                        AND   c.usuario NOT IN ('admin','miguel guevara')
                                        AND   uz.zona_id = :regional" . $sql . "
                                        GROUP BY uz.usuario
                                        ";

                    $temaSql = "SELECT COUNT(*) AS TOTAL, z.nombre AS REGIONAL, n.nombre AS TEMA
                                        FROM capacitacion c, usuario_zona uz, zona z, novedad n
                                        WHERE  c.usuario = uz.usuario
                                        AND   uz.zona_id = z.id
                                        AND   c.usuario NOT IN ('admin','miguel guevara')
                                        AND   c.novedad_id = n.id
                                        AND   n.tipo = 'C'
                                        AND   z.id = :regional" . $sql . "
                                        GROUP BY z.nombre, n.nombre";

                    $coordinadoresCommand = $primaryConnection->createCommand($regionalSql);
                    $temasCommand         = $primaryConnection->createCommand($temaSql);

                    $parametros_array[':regional'] = $regional_id;
                    $consolidadoCoordinadores      = $coordinadoresCommand->bindValues($parametros_array)->queryAll();
                    $consolidadoTemas              = $temasCommand->bindValues($parametros_array)->queryAll();

                    $capacitaciones = array();
                    $temporal       = array();

                    if ($usuarios != null) {

                        foreach ($usuarios as $key) {

                            $usuarioKey = $key->usuario0;
                            //VarDumper::dump($key->);
                            if ($usuarioKey != null) {

                                $rolesKey = $usuarioKey->roles;

                            }

                            if ($rolesKey != null && $rolesKey[0]->rol->id != 1) {

                                $temporal       = Capacitacion::find()->where(['usuario' => $key->usuario])->orderBy(['id' => SORT_DESC])->all();
                                $capacitaciones = array_merge($capacitaciones, $temporal);

                            }

                        }

                    }

                }

            }

        } else {

            $capacitaciones = Capacitacion::find()->where(['usuario' => $id])->orderBy(['id' => SORT_DESC])->all();

        }

        return $this->render('capacitacion', [

            'capacitaciones'           => 'active',
            'capacitaciones_usuario'   => $capacitaciones,
            'usuario'                  => $id,
            'consolidadoCoordinadores' => $consolidadoCoordinadores,
            'consolidadoTemas'         => $consolidadoTemas,

        ]);

    }

    public function actionComite($id)
    {

        //obtener objeto usuario
        $usuarioObj        = Usuario::findOne($id);
        $roles             = array();
        $regional          = false;
        $array_post        = Yii::$app->request->post();
        $primaryConnection = Yii::$app->db;

        if ($usuarioObj != null) {

            $roles = $usuarioObj->roles;

            if ($roles != null) {

                foreach ($roles as $rol) {

                    if ($rol->rol->nombre == 'Coordinador Regional') {

                        $regional = true;
                        break;

                    }

                }

            }

        }

        $consolidadoCoordinadores = array();
        $consolidadoTemas         = array();

        if ($regional) {

            $zonasObj = $usuarioObj->zonas;

            if ($zonasObj != null) {

                foreach ($zonasObj as $zona) {

                    $usuarios    = $zona->zona->usuarios;
                    $regional_id = $zona->zona_id;

                    $sql = '';

                    $parametros_array = array();

                    if (array_key_exists('consultar', $array_post)) {

                        if (array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)) {

                            if ($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != '') {

                                $sql .= ' AND c.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY) ';

                                $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                                $parametros_array[':FECHA_2'] = $array_post['fecha_final'];

                            }

                        }

                    }

                    $regionalSql = "SELECT COUNT(*) AS TOTAL, uz.usuario AS USER
                                        FROM comite c, usuario_zona uz
                                        WHERE  c.usuario = uz.usuario
                                        AND   c.usuario NOT IN ('admin','miguel guevara')
                                        AND   uz.zona_id = :regional" . $sql . "
                                        GROUP BY uz.usuario
                                        ";

                    $temaSql = "SELECT COUNT(*) AS TOTAL, z.nombre AS REGIONAL, n.nombre AS TEMA
                                        FROM comite c, usuario_zona uz, zona z, novedad n
                                        WHERE  c.usuario = uz.usuario
                                        AND   uz.zona_id = z.id
                                        AND   c.usuario NOT IN ('admin','miguel guevara')
                                        AND   c.novedad_id = n.id
                                        AND   n.tipo = 'D'
                                        AND   z.id = :regional" . $sql . "
                                        GROUP BY z.nombre, n.nombre";

                    $coordinadoresCommand = $primaryConnection->createCommand($regionalSql);
                    $temasCommand         = $primaryConnection->createCommand($temaSql);

                    $parametros_array[':regional'] = $regional_id;
                    $consolidadoCoordinadores      = $coordinadoresCommand->bindValues($parametros_array)->queryAll();
                    $consolidadoTemas              = $temasCommand->bindValues($parametros_array)->queryAll();
                    $comites                       = array();
                    $temporal                      = array();

                    if ($usuarios != null) {

                        foreach ($usuarios as $key) {

                            $usuarioKey = $key->usuario0;
                            //VarDumper::dump($key->);
                            if ($usuarioKey != null) {

                                $rolesKey = $usuarioKey->roles;

                            }

                            if ($rolesKey != null && $rolesKey[0]->rol->id != 1) {

                                $temporal = Comite::find()->where(['usuario' => $key->usuario])->orderBy(['id' => SORT_DESC])->all();
                                $comites  = array_merge($comites, $temporal);

                            }

                        }

                    }

                }

            }

        } else {

            $comites = Comite::find()->where(['usuario' => $id])->orderBy(['id' => SORT_DESC])->all();

        }

        return $this->render('comite', [

            'comites'                  => 'active',
            'comites_usuario'          => $comites,
            'usuario'                  => $id,
            'consolidadoCoordinadores' => $consolidadoCoordinadores,
            'consolidadoTemas'         => $consolidadoTemas,

        ]);

    }

    public function actionSiniestro($id)
    {
        //obtener objeto usuario
        $usuarioObj        = Usuario::findOne($id);
        $roles             = array();
        $regional          = false;
        $array_post        = Yii::$app->request->post();
        $primaryConnection = Yii::$app->db;

        if ($usuarioObj != null) {

            $roles = $usuarioObj->roles;

            if ($roles != null) {

                foreach ($roles as $rol) {

                    if ($rol->rol->nombre == 'Coordinador Regional') {

                        $regional = true;
                        break;

                    }

                }

            }

        }

        $consolidadoCoordinadores = array();
        $consolidadoTemas         = array();

        if ($regional) {

            $zonasObj = $usuarioObj->zonas;

            if ($zonasObj != null) {

                foreach ($zonasObj as $zona) {

                    $usuarios    = $zona->zona->usuarios;
                    $regional_id = $zona->zona_id;

                    $sql = '';

                    $parametros_array = array();

                    if (array_key_exists('consultar', $array_post)) {

                        if (array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)) {

                            if ($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != '') {

                                $sql .= ' AND c.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY) ';

                                $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                                $parametros_array[':FECHA_2'] = $array_post['fecha_final'];

                            }

                        }

                    }

                    $regionalSql = "SELECT COUNT(*) AS TOTAL, uz.usuario AS USER
                                        FROM siniestro c, usuario_zona uz
                                        WHERE  c.usuario = uz.usuario
                                        AND   c.usuario NOT IN ('admin','miguel guevara')
                                        AND   uz.zona_id = :regional" . $sql . "
                                        GROUP BY uz.usuario
                                        ";

                    $temaSql = "SELECT COUNT(*) AS TOTAL, z.nombre AS REGIONAL, n.nombre AS TEMA
                                        FROM siniestro c, usuario_zona uz, zona z, novedad n
                                        WHERE  c.usuario = uz.usuario
                                        AND   uz.zona_id = z.id
                                        AND   c.usuario NOT IN ('admin','miguel guevara')
                                        AND   c.novedad_id = n.id
                                        AND   n.tipo = 'S'
                                        AND   z.id = :regional" . $sql . "
                                        GROUP BY z.nombre, n.nombre";

                    $coordinadoresCommand = $primaryConnection->createCommand($regionalSql);
                    $temasCommand         = $primaryConnection->createCommand($temaSql);

                    $parametros_array[':regional'] = $regional_id;
                    $consolidadoCoordinadores      = $coordinadoresCommand->bindValues($parametros_array)->queryAll();
                    $consolidadoTemas              = $temasCommand->bindValues($parametros_array)->queryAll();

                    $siniestros = array();
                    $temporal   = array();

                    if ($usuarios != null) {

                        foreach ($usuarios as $key) {

                            $usuarioKey = $key->usuario0;
                            //VarDumper::dump($key->);
                            if ($usuarioKey != null) {

                                $rolesKey = $usuarioKey->roles;

                            }

                            if ($rolesKey != null && $rolesKey[0]->rol->id != 1) {

                                $temporal   = Siniestro::find()->where(['usuario' => $key->usuario])->orderBy(['id' => SORT_DESC])->all();
                                $siniestros = array_merge($siniestros, $temporal);

                            }

                        }

                    }

                }

            }

        } else {

            $siniestros = Siniestro::find()->where(['usuario' => $id])->orderBy(['id' => SORT_DESC])->all();

        }

        return $this->render('siniestro', [

            'siniestros'               => 'active',
            'siniestros_usuario'       => $siniestros,
            'usuario'                  => $id,
            'consolidadoCoordinadores' => $consolidadoCoordinadores,
            'consolidadoTemas'         => $consolidadoTemas,

        ]);

    }

    public function actionVisita($id)
    {
        //obtener objeto usuario
        $usuarioObj        = Usuario::findOne($id);
        $roles             = array();
        $regional          = false;
        $array_post        = Yii::$app->request->post();
        $primaryConnection = Yii::$app->db;

        if ($usuarioObj != null) {

            $roles = $usuarioObj->roles;

            if ($roles != null) {

                foreach ($roles as $rol) {

                    if ($rol->rol->nombre == 'Coordinador Regional') {

                        $regional = true;
                        break;

                    }

                }

            }

        }

        $consolidadoCoordinadores = array();

        if ($regional) {

            $zonasObj = $usuarioObj->zonas;

            if ($zonasObj != null) {

                foreach ($zonasObj as $zona) {

                    $usuarios    = $zona->zona->usuarios;
                    $sql         = '';
                    $regional_id = $zona->zona_id;

                    $parametros_array = array();

                    if (array_key_exists('consultar', $array_post)) {

                        if (array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)) {

                            if ($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != '') {

                                $sql .= ' AND c.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY) ';

                                $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                                $parametros_array[':FECHA_2'] = $array_post['fecha_final'];

                            }

                        }

                    }

                    $regionalSql = "SELECT COUNT(*) AS TOTAL, uz.usuario AS USER
                                        FROM visita_dia c, usuario_zona uz
                                        WHERE  c.usuario = uz.usuario
                                        AND   c.usuario NOT IN ('admin','miguel guevara')
                                        AND   uz.zona_id = :regional" . $sql . "
                                        GROUP BY uz.usuario
                                        ";

                    $coordinadoresCommand          = $primaryConnection->createCommand($regionalSql);
                    $parametros_array[':regional'] = $regional_id;

                    $consolidadoCoordinadores = $coordinadoresCommand->bindValues($parametros_array)->queryAll();
                    $visitas                  = array();
                    $temporal                 = array();

                    if ($usuarios != null) {

                        foreach ($usuarios as $key) {

                            $usuarioKey = $key->usuario0;
                            //VarDumper::dump($key->);
                            if ($usuarioKey != null) {

                                $rolesKey = $usuarioKey->roles;

                            }

                            if ($rolesKey != null && $rolesKey[0]->rol->id != 1) {

                                $temporal = VisitaDia::find()->where(['usuario' => $key->usuario])->orderBy(['id' => SORT_DESC])->all();
                                $visitas  = array_merge($visitas, $temporal);

                            }

                        }

                    }

                }

            }

        } else {

            $visitas = VisitaDia::find()->where(['usuario' => $id])->orderBy(['id' => SORT_DESC])->all();

        }

        return $this->render('visita', [

            'visitas'                  => 'active',
            'visitas_usuario'          => $visitas,
            'usuario'                  => $id,
            'consolidadoCoordinadores' => $consolidadoCoordinadores,

        ]);

    }

    public function actionIncidente($id)
    {
        //obtener objeto usuario
        $usuarioObj        = Usuario::findOne($id);
        $roles             = array();
        $regional          = false;
        $array_post        = Yii::$app->request->post();
        $primaryConnection = Yii::$app->db;

        if ($usuarioObj != null) {

            $roles = $usuarioObj->roles;

            if ($roles != null) {

                foreach ($roles as $rol) {

                    if ($rol->rol->nombre == 'Coordinador Regional') {

                        $regional = true;
                        break;

                    }

                }

            }

        }

        $consolidadoCoordinadores = array();
        $consolidadoTemas         = array();

        if ($regional) {

            $zonasObj = $usuarioObj->zonas;

            if ($zonasObj != null) {

                foreach ($zonasObj as $zona) {

                    $usuarios    = $zona->zona->usuarios;
                    $regional_id = $zona->zona_id;

                    $sql = '';

                    $parametros_array = array();

                    if (array_key_exists('consultar', $array_post)) {

                        if (array_key_exists('fecha_inicial', $array_post) && array_key_exists('fecha_final', $array_post)) {

                            if ($array_post['fecha_inicial'] != '' && $array_post['fecha_final'] != '') {

                                $sql .= ' AND c.fecha BETWEEN :FECHA_1 AND DATE_ADD(:FECHA_2, INTERVAL 1 DAY) ';

                                $parametros_array[':FECHA_1'] = $array_post['fecha_inicial'];
                                $parametros_array[':FECHA_2'] = $array_post['fecha_final'];

                            }

                        }

                    }

                    $regionalSql = "SELECT COUNT(*) AS TOTAL, uz.usuario AS USER
                                        FROM incidente c, usuario_zona uz
                                        WHERE  c.usuario = uz.usuario
                                        AND   c.usuario NOT IN ('admin','miguel guevara')
                                        AND   uz.zona_id = :regional" . $sql . "
                                        GROUP BY uz.usuario
                                        ";

                    $temaSql = "SELECT COUNT(*) AS TOTAL, z.nombre AS REGIONAL, n.nombre AS TEMA
                                        FROM incidente c, usuario_zona uz, zona z, novedad n
                                        WHERE  c.usuario = uz.usuario
                                        AND   uz.zona_id = z.id
                                        AND   c.usuario NOT IN ('admin','miguel guevara')
                                        AND   c.novedad_id = n.id
                                        AND   n.tipo = 'I'
                                        AND   z.id = :regional" . $sql . "
                                        GROUP BY z.nombre, n.nombre";

                    $coordinadoresCommand = $primaryConnection->createCommand($regionalSql);
                    $temasCommand         = $primaryConnection->createCommand($temaSql);

                    $parametros_array[':regional'] = $regional_id;
                    $consolidadoCoordinadores      = $coordinadoresCommand->bindValues($parametros_array)->queryAll();
                    $consolidadoTemas              = $temasCommand->bindValues($parametros_array)->queryAll();
                    $incidentes                    = array();
                    $temporal                      = array();

                    if ($usuarios != null) {

                        foreach ($usuarios as $key) {

                            $usuarioKey = $key->usuario0;
                            //VarDumper::dump($key->);
                            if ($usuarioKey != null) {

                                $rolesKey = $usuarioKey->roles;

                            }

                            if ($rolesKey != null && $rolesKey[0]->rol->id != 1) {

                                $temporal   = Incidente::find()->where(['usuario' => $key->usuario])->orderBy(['id' => SORT_DESC])->all();
                                $incidentes = array_merge($incidentes, $temporal);

                            }

                        }

                    }

                }

            }

        } else {

            $incidentes = Incidente::find()->where(['usuario' => $id])->orderBy(['id' => SORT_DESC])->all();

        }

        return $this->render('incidente', [

            'investigaciones'          => 'active',
            'incidentes_usuario'       => $incidentes,
            'usuario'                  => $id,
            'consolidadoCoordinadores' => $consolidadoCoordinadores,
            'consolidadoTemas'         => $consolidadoTemas,

        ]);

    }

    public function actionMerma($id)
    {
        //obtener objeto usuario
        $usuarioObj = Usuario::findOne($id);
        $roles      = array();
        $regional   = false;
        if ($usuarioObj != null) {

            $roles = $usuarioObj->roles;

            if ($roles != null) {

                foreach ($roles as $rol) {

                    if ($rol->rol->nombre == 'Coordinador Regional') {

                        $regional = true;
                        break;

                    }

                }

            }

        }

        if ($regional) {

            $zonasObj = $usuarioObj->zonas;

            if ($zonasObj != null) {

                foreach ($zonasObj as $zona) {

                    $usuarios = $zona->zona->usuarios;
                    $mermas   = array();
                    $temporal = array();

                    if ($usuarios != null) {

                        foreach ($usuarios as $key) {

                            $usuarioKey = $key->usuario0;
                            //VarDumper::dump($key->);
                            if ($usuarioKey != null) {

                                $rolesKey = $usuarioKey->roles;

                            }

                            if ($rolesKey != null && $rolesKey[0]->rol->id != 1) {

                                $temporal = Merma::find()->where(['usuario' => $key->usuario])->orderBy(['id' => SORT_DESC])->all();
                                $mermas   = array_merge($mermas, $temporal);

                            }

                        }

                    }

                }

            }

        } else {

            $mermas = Merma::find()->where(['usuario' => $id])->orderBy(['id' => SORT_DESC])->all();

        }

        return $this->render('merma', [

            'investigaciones' => 'active',
            'mermas_usuario'  => $mermas,
            'usuario'         => $id,

        ]);

    }

    public function actionEvento($id)
    {
        //obtener objeto usuario
        $usuarioObj = Usuario::findOne($id);
        $roles      = array();
        $regional   = false;
        if ($usuarioObj != null) {

            $roles = $usuarioObj->roles;

            if ($roles != null) {

                foreach ($roles as $rol) {

                    if ($rol->rol->nombre == 'Coordinador Regional') {

                        $regional = true;
                        break;

                    }

                }

            }

        }

        if ($regional) {

            $zonasObj = $usuarioObj->zonas;

            if ($zonasObj != null) {

                foreach ($zonasObj as $zona) {

                    $usuarios = $zona->zona->usuarios;
                    $visitas  = array();
                    $temporal = array();

                    if ($usuarios != null) {

                        foreach ($usuarios as $key) {

                            $usuarioKey = $key->usuario0;
                            //VarDumper::dump($key->);
                            if ($usuarioKey != null) {

                                $rolesKey = $usuarioKey->roles;

                            }

                            if ($rolesKey != null && $rolesKey[0]->rol->id != 1) {

                                $temporal = Evento::find()->where(['usuario' => $key->usuario])->orderBy(['id' => SORT_DESC])->all();
                                $visitas  = array_merge($visitas, $temporal);

                            }

                        }

                    }

                }

            }

        } else {

            $visitas = Evento::find()->where(['usuario' => $id])->orderBy(['id' => SORT_DESC])->all();

        }

        return $this->render('evento', [

            'visitas'         => 'active',
            'visitas_usuario' => $visitas,
            'usuario'         => $id,

        ]);

    }

/***************Mensual******************/
    public function actionMensual($id)
    {
        //obtener objeto usuario
        $usuarioObj = Usuario::findOne($id);
        $roles      = array();
        $regional   = false;
        if ($usuarioObj != null) {

            $roles = $usuarioObj->roles;

            if ($roles != null) {

                foreach ($roles as $rol) {

                    if ($rol->rol->nombre == 'Coordinador Regional') {

                        $regional = true;
                        break;

                    }

                }

            }

        }

        if ($regional) {

            $zonasObj = $usuarioObj->zonas;

            if ($zonasObj != null) {

                foreach ($zonasObj as $zona) {

                    $usuarios = $zona->zona->usuarios;
                    $visitas  = array();
                    $temporal = array();

                    if ($usuarios != null) {

                        foreach ($usuarios as $key) {

                            $usuarioKey = $key->usuario0;
                            //VarDumper::dump($key->);
                            if ($usuarioKey != null) {

                                $rolesKey = $usuarioKey->roles;

                            }

                            if ($rolesKey != null && $rolesKey[0]->rol->id != 1) {

                                $temporal = VisitaMensual::find()->where(['usuario' => $key->usuario])->orderBy(['id' => SORT_DESC])->all();
                                $visitas  = array_merge($visitas, $temporal);

                            }

                        }

                    }

                }

            }

        } else {

            $visitas = VisitaMensual::find()->where(['usuario' => $id])->orderBy(['id' => SORT_DESC])->all();

        }

        return $this->render('mensual', [

            'visitas'         => 'active',
            'visitas_usuario' => $visitas,
            'usuario'         => $id,

        ]);

    }

/****************************************/

    /**
     * Displays a single Usuario model.
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
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST
        $roles      = Yii::$app->session['rol-exito'];

        $roles     = Rol::find()->orderBy(['nombre' => SORT_ASC])->all();
        $distritos = Distrito::find()->orderBy(['nombre' => SORT_ASC])->all();
        $ciudades  = Ciudad::find()->orderBy(['nombre' => SORT_ASC])->all();
        $marcas    = Marca::find()->orderBy(['nombre' => SORT_ASC])->all();
        $zonas     = Zona::find()->orderBy(['nombre' => SORT_ASC])->all();
        $empresas  = Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();

        $model = new Usuario();

        $primaryConnection = Yii::$app->db;

        $primaryCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_zona
                                                             WHERE usuario = :usuario
                                                             ");

        $secondCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_distrito
                                                             WHERE usuario = :usuario
                                                             ");

        $quintoCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_marca
                                                             WHERE usuario = :usuario
                                                             ");

        $sextoCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_ciudad
                                                             WHERE usuario = :usuario
                                                             ");

        $septimoCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_dependencia
                                                             WHERE usuario = :usuario
                                                             ");

        $octavoCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_empresa
                                                             WHERE usuario = :usuario
                                                             ");

        $thirdCommand = $primaryConnection->createCommand("DELETE
                                                            FROM rol_usuario
                                                            WHERE usuario = :usuario
                                                            ");

        $fourthCommand = $primaryConnection->createCommand("SELECT rol_id
                                                            FROM  rol_usuario
                                                            WHERE usuario = :usuario
                                                            ");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $roles_array     = array_key_exists('roles_array', $array_post) ? $array_post['roles_array'] : array();
            $zonas_array     = array_key_exists('zonas_array', $array_post) ? $array_post['zonas_array'] : array();
            $marcas_array    = array_key_exists('marcas_array', $array_post) ? $array_post['marcas_array'] : array();
            $distritos_array = array_key_exists('distritos_array', $array_post) ? $array_post['distritos_array'] : array();
            $empresas_array  = array_key_exists('empresas_array', $array_post) ? $array_post['empresas_array'] : array();
            $usuario         = $model->getAttribute('usuario');
            $thirdCommand->bindValue(':usuario', $usuario)->execute();
            $tamano_roles     = count($roles_array);
            $tamano_zonas     = count($zonas_array);
            $tamano_distritos = count($distritos_array);
            $tamano_marcas    = count($marcas_array);
            $tamano_empresas  = count($empresas_array);
            $tipo_area        = array_key_exists('tipo-area', $array_post) ? $array_post['tipo-area'] : '';

            if ($tipo_area == 'on') {

                $model->setAttribute('ambas_areas', 'S');
                $model->save();

            }

            $index = 0;

            while ($index < $tamano_roles) {

                /*Modelo principal guardado*/
                $usuario_roles_model = new RolUsuario();
                /*establecer valores de Atributos del objeto prorroga*/
                $usuario_roles_model->setAttribute('usuario', $usuario);
                $usuario_roles_model->setAttribute('rol_id', $roles_array[$index]);
                $usuario_roles_model->save();

                $index++;

            }

            $index = 0;

            while ($index < $tamano_zonas) {

                /*Modelo principal guardado*/
                $usuario_zonas_model = new UsuarioZona();
                /*establecer valores de Atributos del objeto prorroga*/
                $usuario_zonas_model->setAttribute('usuario', $usuario);
                $usuario_zonas_model->setAttribute('zona_id', $zonas_array[$index]);
                $usuario_zonas_model->save();

                $index++;

            }

            $index = 0;

            while ($index < $tamano_distritos) {

                /*Modelo principal guardado*/
                $usuario_distritos_model = new UsuarioDistrito();
                /*establecer valores de Atributos del objeto prorroga*/
                $usuario_distritos_model->setAttribute('usuario', $usuario);
                $usuario_distritos_model->setAttribute('distrito_id', $distritos_array[$index]);
                $usuario_distritos_model->save();

                $index++;

            }

            $index = 0;

            while ($index < $tamano_marcas) {

                /*Modelo principal guardado*/
                $usuario_marcas_model = new UsuarioMarca();
                /*establecer valores de Atributos del objeto prorroga*/
                $usuario_marcas_model->setAttribute('usuario', $usuario);
                $usuario_marcas_model->setAttribute('marca_id', $marcas_array[$index]);
                $usuario_marcas_model->save();

                $index++;

            }

            $index = 0;

            while ($index < $tamano_empresas) {

                /*Modelo principal guardado*/
                $usuario_empresa_model = new UsuarioEmpresa();
                /*establecer valores de Atributos del objeto prorroga*/
                $usuario_empresa_model->setAttribute('usuario', $usuario);
                $usuario_empresa_model->setAttribute('nit', $empresas_array[$index]);
                $usuario_empresa_model->save();

                $index++;

            }

            return $this->redirect('index');

        } else {
            return $this->render('create', [
                'model'     => $model,
                'roles'     => $roles,
                'distritos' => $distritos,
                'marcas'    => $marcas,
                'ciudades'  => $ciudades,
                'zonas'     => $zonas,
                'empresas'  => $empresas,

            ]);
        }
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $array_post = Yii::$app->request->post(); // almacenar variables POST
        $roles      = Yii::$app->session['rol-exito'];

        $model     = $this->findModel($id);
        $roles     = Rol::find()->orderBy(['nombre' => SORT_ASC])->all();
        $distritos = Distrito::find()->orderBy(['nombre' => SORT_ASC])->all();
        $ciudades  = Ciudad::find()->orderBy(['nombre' => SORT_ASC])->all();
        $marcas    = Marca::find()->orderBy(['nombre' => SORT_ASC])->all();
        $zonas     = Zona::find()->orderBy(['nombre' => SORT_ASC])->all();
        $empresas  = Empresa::find()->orderBy(['nombre' => SORT_ASC])->all();

        $primaryConnection = Yii::$app->db;

        $primaryCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_zona
                                                             WHERE usuario = :usuario
                                                             ");

        $zonaCommand = $primaryConnection->createCommand("SELECT zona_id
                                                            FROM  usuario_zona
                                                            WHERE usuario = :usuario
                                                            ");

        $secondCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_distrito
                                                             WHERE usuario = :usuario
                                                             ");

        $distritoCommand = $primaryConnection->createCommand("SELECT distrito_id
                                                            FROM  usuario_distrito
                                                            WHERE usuario = :usuario
                                                            ");

        $quintoCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_marca
                                                             WHERE usuario = :usuario
                                                             ");

        $marcaCommand = $primaryConnection->createCommand("SELECT marca_id
                                                            FROM  usuario_marca
                                                            WHERE usuario = :usuario
                                                            ");

        $empresaCommand = $primaryConnection->createCommand("SELECT nit
                                                            FROM  usuario_empresa
                                                            WHERE usuario = :usuario
                                                            ");

        $sextoCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_ciudad
                                                             WHERE usuario = :usuario
                                                             ");

        $septimoCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_dependencia
                                                             WHERE usuario = :usuario
                                                             ");

        $octavoCommand = $primaryConnection->createCommand("DELETE
                                                             FROM usuario_empresa
                                                             WHERE usuario = :usuario
                                                             ");

        $thirdCommand = $primaryConnection->createCommand("DELETE
                                                            FROM rol_usuario
                                                            WHERE usuario = :usuario
                                                            ");

        $fourthCommand = $primaryConnection->createCommand("SELECT rol_id
                                                            FROM  rol_usuario
                                                            WHERE usuario = :usuario
                                                            ");

        $usuario = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $roles_array     = array_key_exists('roles_array', $array_post) ? $array_post['roles_array'] : array();
            $zonas_array     = array_key_exists('zonas_array', $array_post) ? $array_post['zonas_array'] : array();
            $marcas_array    = array_key_exists('marcas_array', $array_post) ? $array_post['marcas_array'] : array();
            $distritos_array = array_key_exists('distritos_array', $array_post) ? $array_post['distritos_array'] : array();
            $empresas_array  = array_key_exists('empresas_array', $array_post) ? $array_post['empresas_array'] : array();
            $usuario         = $model->getAttribute('usuario');
            $thirdCommand->bindValue(':usuario', $usuario)->execute();
            $primaryCommand->bindValue(':usuario', $usuario)->execute();
            $secondCommand->bindValue(':usuario', $usuario)->execute();
            $quintoCommand->bindValue(':usuario', $usuario)->execute();
            $octavoCommand->bindValue(':usuario', $usuario)->execute();
            $tamano_roles     = count($roles_array);
            $tamano_zonas     = count($zonas_array);
            $tamano_distritos = count($distritos_array);
            $tamano_marcas    = count($marcas_array);
            $tamano_empresas  = count($empresas_array);
            $tipo_area        = array_key_exists('tipo-area', $array_post) ? $array_post['tipo-area'] : '';

            if ($tipo_area == 'on') {

                $model->setAttribute('ambas_areas', 'S');
                $model->save();

            }

            $index = 0;

            while ($index < $tamano_roles) {

                /*Modelo principal guardado*/
                $usuario_roles_model = new RolUsuario();
                /*establecer valores de Atributos del objeto prorroga*/
                $usuario_roles_model->SetAttribute('usuario', $usuario);
                $usuario_roles_model->SetAttribute('rol_id', $roles_array[$index]);
                $usuario_roles_model->save();

                $index++;

            }

            $index = 0;

            while ($index < $tamano_zonas) {

                /*Modelo principal guardado*/
                $usuario_zonas_model = new UsuarioZona();
                /*establecer valores de Atributos del objeto prorroga*/
                $usuario_zonas_model->setAttribute('usuario', $usuario);
                $usuario_zonas_model->setAttribute('zona_id', $zonas_array[$index]);
                $usuario_zonas_model->save();

                $index++;

            }

            $index = 0;

            while ($index < $tamano_distritos) {

                /*Modelo principal guardado*/
                $usuario_distritos_model = new UsuarioDistrito();
                /*establecer valores de Atributos del objeto prorroga*/
                $usuario_distritos_model->setAttribute('usuario', $usuario);
                $usuario_distritos_model->setAttribute('distrito_id', $distritos_array[$index]);
                $usuario_distritos_model->save();

                $index++;

            }

            $index = 0;

            while ($index < $tamano_marcas) {

                /*Modelo principal guardado*/
                $usuario_marcas_model = new UsuarioMarca();
                /*establecer valores de Atributos del objeto prorroga*/
                $usuario_marcas_model->setAttribute('usuario', $usuario);
                $usuario_marcas_model->setAttribute('marca_id', $marcas_array[$index]);
                $usuario_marcas_model->save();

                $index++;

            }

            $index = 0;

            while ($index < $tamano_empresas) {

                /*Modelo principal guardado*/
                $usuario_empresa_model = new UsuarioEmpresa();
                /*establecer valores de Atributos del objeto prorroga*/
                $usuario_empresa_model->setAttribute('usuario', $usuario);
                $usuario_empresa_model->setAttribute('nit', $empresas_array[$index]);
                $usuario_empresa_model->save();

                $index++;

            }

            return $this->redirect('index');
        } else {

            $roles_actuales     = $fourthCommand->bindValue(':usuario', $usuario)->queryAll();
            $zonas_actuales     = $zonaCommand->bindValue(':usuario', $usuario)->queryAll();
            $distritos_actuales = $distritoCommand->bindValue(':usuario', $usuario)->queryAll();
            $marcas_actuales    = $marcaCommand->bindValue(':usuario', $usuario)->queryAll();
            $empresas_actuales  = $empresaCommand->bindValue(':usuario', $usuario)->queryAll();

            return $this->render('update', [
                'model'              => $model,
                'roles'              => $roles,
                'roles_actuales'     => $roles_actuales,
                'zonas'              => $zonas,
                'distritos'          => $distritos,
                'marcas'             => $marcas,
                'marcas_actuales'    => $marcas_actuales,
                'zonas_actuales'     => $zonas_actuales,
                'distritos_actuales' => $distritos_actuales,
                'empresas_actuales'  => $empresas_actuales,
                'empresas'           => $empresas,
            ]);
        }
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
