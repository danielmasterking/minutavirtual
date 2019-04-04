<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prefactura_dispositivo_variable_electronico".
 *
 * @property integer $id
 * @property string $sistema
 * @property integer $id_tipo_alarma
 * @property integer $id_marca
 * @property string $referencia
 * @property integer $ubicacion
 * @property string $zona_panel
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $valor_novedad
 * @property string $centro_costos_codigo
 * @property integer $id_desc
 * @property integer $id_prefactura_electronica
 * @property integer $id_tipo_servicio
 * @property integer $total_dias
 */
class PrefacturaDispositivoVariableElectronico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prefactura_dispositivo_variable_electronico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo_alarma','id_desc','id_marca','sistema','referencia','ubicacion','zona_panel','valor_novedad'],'required'],
            [['id_tipo_alarma', 'id_marca', 'ubicacion', 'id_desc', 'id_prefactura_electronica', 'id_tipo_servicio', 'total_dias'], 'integer'],
            [['referencia'], 'string'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['sistema'], 'string', 'max' => 30],
            [['zona_panel'], 'string', 'max' => 50],
            [['valor_novedad', 'centro_costos_codigo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sistema' => 'Sistema',
            'id_tipo_alarma' => 'Tipo Alarma',
            'id_marca' => 'Marca',
            'referencia' => 'Referencia',
            'ubicacion' => 'Ubicacion',
            'zona_panel' => '#Zona Panel',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'valor_novedad' => 'Valor Novedad',
            'centro_costos_codigo' => 'Centro Costos Codigo',
            'id_desc' => 'Descripcion',
            'id_prefactura_electronica' => 'Id Prefactura Electronica',
            'id_tipo_servicio' => 'Tipo Servicio',
            'total_dias' => 'Total Dias',
        ];
    }


    public function getIdPrefacturaelectronica()
    {
        return $this->hasOne(PrefacturaFija::className(), ['id' => 'id_prefactura_electronica']);
    }


    public function getTipoalarma()
    {
        return $this->hasOne(TipoAlarma::className(), ['id' => 'id_tipo_alarma']);
    }

    public function getMarcaalarma()
    {
        return $this->hasOne(MarcaAlarma::className(), ['id' => 'id_marca']);
    }


    public function getAreas()
    {
        return $this->hasOne(AreaDependencia::className(), ['id' => 'ubicacion']);
    }


    public function getDesc()
    {
        return $this->hasOne(DescAlarma::className(), ['id' => 'id_desc']);
    }

    public function getServicios()
    {
        return $this->hasOne(TipoServicioElectronica::className(), ['id' => 'id_tipo_servicio']);
    }


}
