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



}
