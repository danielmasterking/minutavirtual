<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ciudad".
 *
 * @property string $codigo_dane
 * @property string $nombre
 *
 * @property CentroCosto[] $centroCostos
 * @property CiudadZona[] $ciudadZonas
 */
class Ciudad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ciudad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo_dane', 'nombre'], 'required'],
            [['codigo_dane'], 'string', 'max' => 8],
            [['nombre'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo_dane' => 'Codigo Dane',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentroCostos()
    {
        return $this->hasMany(CentroCosto::className(), ['ciudad_codigo_dane' => 'codigo_dane']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudadZonas()
    {
        return $this->hasMany(CiudadZona::className(), ['ciudad_codigo_dane' => 'codigo_dane']);
    }
    public function getZona()
    {
        return $this->hasOne(CiudadZona::className(), ['ciudad_codigo_dane' => 'codigo_dane']);
    }
}
