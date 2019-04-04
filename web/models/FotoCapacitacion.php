<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "foto_capacitacion".
 *
 * @property integer $id
 * @property string $imagen
 * @property integer $capacitacion_id
 *
 * @property Capacitacion $capacitacion
 */
class FotoCapacitacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foto_capacitacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imagen', 'capacitacion_id'], 'required'],
            [['capacitacion_id'], 'integer'],
            [['imagen'], 'string', 'max' => 500],
            [['capacitacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Capacitacion::className(), 'targetAttribute' => ['capacitacion_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imagen' => 'Imagen',
            'capacitacion_id' => 'Capacitacion ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCapacitacion()
    {
        return $this->hasOne(Capacitacion::className(), ['id' => 'capacitacion_id']);
    }
}
