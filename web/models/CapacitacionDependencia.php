<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "capacitacion_dependencia".
 *
 * @property integer $cantidad
 * @property integer $capacitacion_id
 * @property string $centro_costo_codigo
 *
 * @property Capacitacion $capacitacion
 * @property CentroCosto $centroCostoCodigo
 */
class CapacitacionDependencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'capacitacion_dependencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cantidad', 'capacitacion_id', 'centro_costo_codigo'], 'required'],
            [['cantidad', 'capacitacion_id'], 'integer'],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['capacitacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Capacitacion::className(), 'targetAttribute' => ['capacitacion_id' => 'id']],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cantidad' => 'Cantidad',
            'capacitacion_id' => 'Capacitacion ID',
            'centro_costo_codigo' => 'Centro Costo Codigo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCapacitacion()
    {
        return $this->hasOne(Capacitacion::className(), ['id' => 'capacitacion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
