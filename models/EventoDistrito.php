<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evento_distrito".
 *
 * @property integer $evento_id
 * @property integer $distrito_id
 *
 * @property Evento $evento
 * @property Distrito $distrito
 */
class EventoDistrito extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evento_distrito';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['evento_id', 'distrito_id'], 'required'],
            [['evento_id', 'distrito_id'], 'integer'],
            [['evento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['evento_id' => 'id']],
            [['distrito_id'], 'exist', 'skipOnError' => true, 'targetClass' => Distrito::className(), 'targetAttribute' => ['distrito_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'evento_id' => 'Evento ID',
            'distrito_id' => 'Distrito ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvento()
    {
        return $this->hasOne(Evento::className(), ['id' => 'evento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrito()
    {
        return $this->hasOne(Distrito::className(), ['id' => 'distrito_id']);
    }
}
