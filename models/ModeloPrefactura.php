<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modelo_prefactura".
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
 *
 * @property Puesto $puesto
 * @property DetalleServicio $detalleServicio
 * @property CentroCosto $centroCostoCodigo
 */
class ModeloPrefactura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modelo_prefactura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['puesto_id', 'detalle_servicio_id', 'cantidad_servicios', 'horas', 'porcentaje', 'ftes', 'total_dias', 'valor_mes', 'centro_costo_codigo'], 'required'],
            [['puesto_id', 'detalle_servicio_id', 'cantidad_servicios', 'porcentaje', 'total_dias'], 'integer'],
            [['ftes', 'valor_mes'], 'number'],
            [['cantidad_servicios'], 'number', 'max' => 10],
            [['horas', 'hora_inicio', 'hora_fin'], 'string', 'max' => 8],
            [['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'festivo'], 'string', 'max' => 1],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['puesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Puesto::className(), 'targetAttribute' => ['puesto_id' => 'id']],
            [['detalle_servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => DetalleServicio::className(), 'targetAttribute' => ['detalle_servicio_id' => 'id']],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'puesto_id' => 'Puesto',
            'detalle_servicio_id' => 'Servicio',
            'cantidad_servicios' => 'Cantidad Servicios',
            'horas' => 'Jornada Horas',
            'lunes' => '',
            'martes' => '',
            'miercoles' => '',
            'jueves' => '',
            'viernes' => '',
            'sabado' => '',
            'domingo' => '',
            'festivo' => '',
            'hora_inicio' => 'Desde',
            'hora_fin' => 'Hasta',
            'porcentaje' => 'Porcentaje de Cobro',
            'ftes' => 'Ftes',
            'total_dias' => 'Total Dias',
            'valor_mes' => 'Valor Mes',
            'centro_costo_codigo' => 'Centro Costo',
        ];
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
    public function getServicio()
    {
        return $this->hasOne(DetalleServicio::className(), ['id' => 'detalle_servicio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentroCostoCodigo()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
