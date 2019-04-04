<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "novedad_rol".
 *
 * @property integer $novedad_id
 * @property integer $rol_id
 *
 * @property Novedad $novedad
 * @property Rol $rol
 */
class NovedadRol extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'novedad_rol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['novedad_id', 'rol_id'], 'required'],
            [['novedad_id', 'rol_id'], 'integer'],
            [['novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Novedad::className(), 'targetAttribute' => ['novedad_id' => 'id']],
            [['rol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['rol_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'novedad_id' => 'Novedad ID',
            'rol_id' => 'Rol ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedad()
    {
        return $this->hasOne(Novedad::className(), ['id' => 'novedad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'rol_id']);
    }
}
