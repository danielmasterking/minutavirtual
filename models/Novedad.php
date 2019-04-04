<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "novedad".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $tipo
 *
 * @property NovedadRol[] $novedadRols
 * @property Subnovedad[] $subnovedads
 */
class Novedad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'novedad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 80],
            [['tipo'], 'string', 'max' => 1],
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
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedadRols()
    {
        return $this->hasMany(NovedadRol::className(), ['novedad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubnovedads()
    {
        return $this->hasMany(Subnovedad::className(), ['novedad_id' => 'id']);
    }
}
