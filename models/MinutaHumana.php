<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "minuta_humana".
 *
 * @property integer $id
 * @property integer $cedula_persona
 * @property string $hora_entrada
 * @property string $hora_salida
 * @property string $fecha
 * @property integer $tipo_observacion
 * @property integer $tipo_invitado
 */
class MinutaHumana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'minuta_humana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cedula_persona', 'hora_entrada','tipo_observacion', 'tipo_invitado','codigo_dependencia','puesto'], 'required'],
            [['cedula_persona', 'tipo_observacion', 'tipo_invitado'], 'integer'],
            [['hora_entrada', 'hora_salida', 'fecha','observacion','observacion_salida'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cedula_persona' => 'Cedula Persona',
            'hora_entrada' => 'Hora',
            'hora_salida' => 'Hora Salida',
            'fecha' => 'Fecha',
            'tipo_observacion' => 'Area',
            'tipo_invitado' => 'Tipo ',
            'nit_empresa'=>'Empresa',
            'codigo_dependencia'=>'Dependencia',
            'observacion'=>'Observacion adicional',
            'puesto'=>'Puesto',
            'observacion_salida'=>'Observacion salida'
        ];
    }


    public function getPersona()
    {
        return $this->hasMany(Personas::className(), ['cedula' => 'cedula_persona']);
    }


    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['nit' => 'nit_empresa']);
    }


    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'codigo_dependencia']);
    }

    public function Registros($id,$fecha){
        $rows = (new \yii\db\Query())
         ->select(['m.id','m.cedula_persona','m.hora_entrada','m.hora_salida','m.fecha','emp.nombre empresa','u.usuario','CONCAT(p.nombres, " ", p.apellidos) Persona','cc.nombre dependencia','ti.nombre tipo_invitado','to.nombre tipo_observacion','m.observacion','m.puesto','m.observacion_salida'])
         ->from('minuta_humana m')
         ->leftJoin('tipo_invitado ti', 'm.tipo_invitado = ti.id')
         ->leftJoin('tipo_observacion to', 'm.tipo_observacion = to.id')
         ->leftJoin('empresa emp', 'm.nit_empresa = emp.nit')
         ->leftJoin('personas p', 'm.cedula_persona = p.cedula')
         ->leftJoin('usuario u', 'm.usuario = u.usuario')
         ->leftJoin('centro_costo cc', 'm.codigo_dependencia = cc.codigo')
         ->where('m.fecha="'.$fecha.'" AND m.cedula_persona='.$id.'');


        $ordenado='m.id';
        $rows->orderBy([$ordenado => SORT_ASC]);
        $command = $rows->createCommand();
        //echo $command->sql;exit();
        $query = $command->queryAll();

        return $query;
    }


}
