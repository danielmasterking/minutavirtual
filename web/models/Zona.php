<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zona".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property CiudadZona[] $ciudadZonas
 */
class Zona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 80],
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
    public function getCiudades()
    {
        return $this->hasMany(CiudadZona::className(), ['zona_id' => 'id']);
    }
	
	 public function getDistritos()
    {
        return $this->hasMany(DistritoZona::className(), ['zona_id' => 'id']);
    }
	
	 public function getUsuarios()
    {
        return $this->hasMany(UsuarioZona::className(), ['zona_id' => 'id']);
    }
}
