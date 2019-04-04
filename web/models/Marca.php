<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "marca".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property CentroCosto[] $centroCostos
 */
class Marca extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'marca';
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
    public function getCentroCostos()
    {
        return $this->hasMany(CentroCosto::className(), ['marca_id' => 'id']);
    }
}
