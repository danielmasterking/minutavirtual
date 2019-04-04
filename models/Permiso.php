<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permiso".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property PermisoRol[] $permisoRols
 */
class Permiso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permiso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermisoRols()
    {
        return $this->hasMany(PermisoRol::className(), ['permiso_id' => 'id']);
    }
}
