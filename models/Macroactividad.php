<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "macroactividad".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $peso
 * @property integer $metrica_id
 *
 * @property Metrica $metrica
 * @property Microactividad[] $microactividads
 */
class Macroactividad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'macroactividad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'metrica_id'], 'required'],
            [['peso', 'metrica_id'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
            [['metrica_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metrica::className(), 'targetAttribute' => ['metrica_id' => 'id']],
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
            'peso' => 'Peso (%)',
            'metrica_id' => 'Metrica',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetrica()
    {
        return $this->hasOne(Metrica::className(), ['id' => 'metrica_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMicroactividades()
    {
        return $this->hasMany(Microactividad::className(), ['macroactividad_id' => 'id']);
    }
}
