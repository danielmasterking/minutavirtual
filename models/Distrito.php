<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distrito".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property CentroDistrito[] $centroDistritos
 * @property UsuarioDistrito[] $usuarioDistritos
 */
class Distrito extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'distrito';
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
    public function getDependencias()
    {
        return $this->hasMany(CentroDistrito::className(), ['distrito_id' => 'id']);
    }
	
	 public function getZonas()
    {
        return $this->hasMany(DistritoZona::className(), ['distrito_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioDependencias()
    {
        return $this->hasMany(UsuarioDistrito::className(), ['distrito_id' => 'id']);
    }
}
