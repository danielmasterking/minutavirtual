<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comite_marca".
 *
 * @property integer $comite_id
 * @property integer $marca_id
 *
 * @property Comite $comite
 * @property Marca $marca
 */
class ComiteMarca extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comite_marca';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comite_id', 'marca_id'], 'required'],
            [['comite_id', 'marca_id'], 'integer'],
            [['comite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comite::className(), 'targetAttribute' => ['comite_id' => 'id']],
            [['marca_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marca::className(), 'targetAttribute' => ['marca_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comite_id' => 'Comite ID',
            'marca_id' => 'Marca ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComite()
    {
        return $this->hasOne(Comite::className(), ['id' => 'comite_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarca()
    {
        return $this->hasOne(Marca::className(), ['id' => 'marca_id']);
    }
}
