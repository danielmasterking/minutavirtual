<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subnovedad".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $novedad_id
 *
 * @property Novedad $novedad
 */
class Subnovedad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subnovedad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'novedad_id'], 'required'],
            [['novedad_id'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
            [['novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Novedad::className(), 'targetAttribute' => ['novedad_id' => 'id']],
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
            'novedad_id' => 'Novedad ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedad()
    {
        return $this->hasOne(Novedad::className(), ['id' => 'novedad_id']);
    }
}
