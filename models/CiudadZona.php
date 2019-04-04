<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ciudad_zona".
 *
 * @property string $ciudad_codigo_dane
 * @property integer $zona_id
 *
 * @property Ciudad $ciudadCodigoDane
 * @property Zona $zona
 */
class CiudadZona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ciudad_zona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ciudad_codigo_dane', 'zona_id'], 'required'],
            [['zona_id'], 'integer'],
            [['ciudad_codigo_dane'], 'string', 'max' => 8],
            [['ciudad_codigo_dane'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['ciudad_codigo_dane' => 'codigo_dane']],
            [['zona_id'], 'exist', 'skipOnError' => true, 'targetClass' => Zona::className(), 'targetAttribute' => ['zona_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ciudad_codigo_dane' => 'Ciudad Codigo Dane',
            'zona_id' => 'Zona ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudad()
    {
        return $this->hasOne(Ciudad::className(), ['codigo_dane' => 'ciudad_codigo_dane']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZona()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id']);
    }
}
