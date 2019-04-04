<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permiso_rol".
 *
 * @property integer $rol_id
 * @property integer $permiso_id
 *
 * @property Rol $rol
 * @property Permiso $permiso
 */
class PermisoRol extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permiso_rol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rol_id', 'permiso_id'], 'required'],
            [['rol_id', 'permiso_id'], 'integer'],
            [['rol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['rol_id' => 'id']],
            [['permiso_id'], 'exist', 'skipOnError' => true, 'targetClass' => Permiso::className(), 'targetAttribute' => ['permiso_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rol_id' => 'Rol ID',
            'permiso_id' => 'Permiso ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'rol_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermiso()
    {
        return $this->hasOne(Permiso::className(), ['id' => 'permiso_id']);
    }
}
