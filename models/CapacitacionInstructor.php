<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "capacitacion_instructor".
 *
 * @property integer $capacitacion_id
 * @property string $instructor
 *
 * @property Capacitacion $capacitacion
 * @property Usuario $instructor0
 */
class CapacitacionInstructor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'capacitacion_instructor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['capacitacion_id', 'instructor'], 'required'],
            [['capacitacion_id', 'asistentes'], 'integer'],
            [['instructor'], 'string', 'max' => 50],
            [['capacitacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Capacitacion::className(), 'targetAttribute' => ['capacitacion_id' => 'id']],
            [['instructor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['instructor' => 'usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'capacitacion_id' => 'Capacitacion ID',
            'instructor' => 'Instructor',
			'asistentes' => 'Asistentes',
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
    public function getInstructor()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'instructor']);
    }
}
