<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prefactura_dispositivo".
 *
 * @property integer $id
 * @property integer $puesto_id
 * @property integer $detalle_servicio_id
 * @property integer $cantidad_servicios
 * @property string $horas
 * @property string $lunes
 * @property string $martes
 * @property string $miercoles
 * @property string $jueves
 * @property string $viernes
 * @property string $sabado
 * @property string $domingo
 * @property string $festivo
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property integer $porcentaje
 * @property string $ftes
 * @property integer $total_dias
 * @property string $valor_mes
 * @property string $centro_costo_codigo
 * @property integer $id_prefactura_fija
 * @property string $tipo
 *
 * @property DetalleServicio $detalleServicio
 * @property Puesto $puesto
 * @property CentroCosto $centroCostoCodigo
 * @property PrefacturaFija $idPrefacturaFija
 */
class PrefacturaDispositivo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prefactura_dispositivo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['puesto_id', 'detalle_servicio_id', 'cantidad_servicios', 'horas', 'porcentaje', 'ftes', 'total_dias', 'valor_mes', 'centro_costo_codigo', 'id_prefactura_fija'], 'required'],
            [['puesto_id', 'detalle_servicio_id', 'cantidad_servicios', 'porcentaje', 'total_dias', 'id_prefactura_fija'], 'integer'],
            [['horas', 'hora_inicio', 'hora_fin'], 'safe'],
            [['ftes', 'valor_mes'], 'number'],
            [['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'festivo'], 'string', 'max' => 1],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['tipo'], 'string', 'max' => 50],
            [['detalle_servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => DetalleServicio::className(), 'targetAttribute' => ['detalle_servicio_id' => 'id']],
            [['puesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Puesto::className(), 'targetAttribute' => ['puesto_id' => 'id']],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
            [['id_prefactura_fija'], 'exist', 'skipOnError' => true, 'targetClass' => PrefacturaFija::className(), 'targetAttribute' => ['id_prefactura_fija' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'puesto_id' => 'Puesto ID',
            'detalle_servicio_id' => 'Detalle Servicio ID',
            'cantidad_servicios' => 'Cantidad Servicios',
            'horas' => 'Horas',
            'lunes' => '',
            'martes' => '',
            'miercoles' => '',
            'jueves' => '',
            'viernes' => '',
            'sabado' => '',
            'domingo' => '',
            'festivo' => '',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
            'porcentaje' => 'Porcentaje',
            'ftes' => 'Ftes',
            'total_dias' => 'Total Dias',
            'valor_mes' => 'Valor Mes',
            'centro_costo_codigo' => 'Centro Costo Codigo',
            'id_prefactura_fija' => 'Id Prefactura Fija',
            'tipo' => 'fijo o variable',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicio()
    {
        return $this->hasOne(DetalleServicio::className(), ['id' => 'detalle_servicio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuesto()
    {
        return $this->hasOne(Puesto::className(), ['id' => 'puesto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentroCostoCodigo()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPrefacturaFija()
    {
        return $this->hasOne(PrefacturaFija::className(), ['id' => 'id_prefactura_fija']);
    }
}
