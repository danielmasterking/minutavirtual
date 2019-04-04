<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_prefactura_fija".
 *
 * @property integer $id
 * @property integer $prefactura_fija_id
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
 *
 * @property PrefacturaFija $prefacturaFija
 * @property Puesto $puesto
 * @property DetalleServicio $detalleServicio
 */
class DetallePrefacturaFija extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_prefactura_fija';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prefactura_fija_id', 'puesto_id', 'detalle_servicio_id', 'cantidad_servicios', 'horas', 'porcentaje', 'ftes', 'total_dias', 'valor_mes'], 'required'],
            [['prefactura_fija_id', 'puesto_id', 'detalle_servicio_id', 'cantidad_servicios', 'porcentaje', 'total_dias'], 'integer'],
            [['ftes', 'valor_mes'], 'number'],
            [['horas', 'hora_inicio', 'hora_fin'], 'string', 'max' => 5],
            [['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'festivo'], 'string', 'max' => 1],
            [['prefactura_fija_id'], 'exist', 'skipOnError' => true, 'targetClass' => PrefacturaFija::className(), 'targetAttribute' => ['prefactura_fija_id' => 'id']],
            [['puesto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Puesto::className(), 'targetAttribute' => ['puesto_id' => 'id']],
            [['detalle_servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => DetalleServicio::className(), 'targetAttribute' => ['detalle_servicio_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prefactura_fija_id' => 'Prefactura Fija ID',
            'puesto_id' => 'Puesto ID',
            'detalle_servicio_id' => 'Detalle Servicio ID',
            'cantidad_servicios' => 'Cantidad Servicios',
            'horas' => 'Horas',
            'lunes' => 'Lunes',
            'martes' => 'Martes',
            'miercoles' => 'Miercoles',
            'jueves' => 'Jueves',
            'viernes' => 'Viernes',
            'sabado' => 'Sabado',
            'domingo' => 'Domingo',
            'festivo' => 'Festivo',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
            'porcentaje' => 'Porcentaje',
            'ftes' => 'Ftes',
            'total_dias' => 'Total Dias',
            'valor_mes' => 'Valor Mes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrefacturaFija()
    {
        return $this->hasOne(PrefacturaFija::className(), ['id' => 'prefactura_fija_id']);
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
    public function getDetalleServicio()
    {
        return $this->hasOne(DetalleServicio::className(), ['id' => 'detalle_servicio_id']);
    }
}
