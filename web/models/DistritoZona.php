<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distrito_zona".
 *
 * @property integer $zona_id
 * @property integer $distrito_id
 *
 * @property Zona $zona
 * @property Distrito $distrito
 */
class DistritoZona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'distrito_zona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zona_id', 'distrito_id'], 'required'],
            [['zona_id', 'distrito_id'], 'integer'],
            [['zona_id'], 'exist', 'skipOnError' => true, 'targetClass' => Zona::className(), 'targetAttribute' => ['zona_id' => 'id']],
            [['distrito_id'], 'exist', 'skipOnError' => true, 'targetClass' => Distrito::className(), 'targetAttribute' => ['distrito_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'zona_id' => 'Zona ID',
            'distrito_id' => 'Distrito ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZona()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrito()
    {
        return $this->hasOne(Distrito::className(), ['id' => 'distrito_id']);
    }
}
