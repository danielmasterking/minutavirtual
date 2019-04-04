<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comite_distrito".
 *
 * @property integer $comite_id
 * @property integer $distrito_id
 *
 * @property Comite $comite
 * @property Distrito $distrito
 */
class ComiteDistrito extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comite_distrito';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comite_id', 'distrito_id'], 'required'],
            [['comite_id', 'distrito_id'], 'integer'],
            [['comite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comite::className(), 'targetAttribute' => ['comite_id' => 'id']],
            [['distrito_id'], 'exist', 'skipOnError' => true, 'targetClass' => Distrito::className(), 'targetAttribute' => ['distrito_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comite_id' => 'Comite ID',
            'distrito_id' => 'Distrito ID',
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
    public function getDistrito()
    {
        return $this->hasOne(Distrito::className(), ['id' => 'distrito_id']);
    }
}
