<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "formato_rol".
 *
 * @property integer $formato_id
 * @property integer $rol_id
 *
 * @property Formato $formato
 * @property Rol $rol
 */
class FormatoRol extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'formato_rol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['formato_id', 'rol_id'], 'required'],
            [['formato_id', 'rol_id'], 'integer'],
            [['formato_id'], 'exist', 'skipOnError' => true, 'targetClass' => Formato::className(), 'targetAttribute' => ['formato_id' => 'id']],
            [['rol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['rol_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'formato_id' => 'Formato ID',
            'rol_id' => 'Rol ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormato()
    {
        return $this->hasOne(Formato::className(), ['id' => 'formato_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'rol_id']);
    }
}
