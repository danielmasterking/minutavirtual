<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evento_marca".
 *
 * @property integer $evento_id
 * @property integer $marca_id
 *
 * @property Evento $evento
 * @property Marca $marca
 */
class EventoMarca extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evento_marca';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['evento_id', 'marca_id'], 'required'],
            [['evento_id', 'marca_id'], 'integer'],
            [['evento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['evento_id' => 'id']],
            [['marca_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marca::className(), 'targetAttribute' => ['marca_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'evento_id' => 'Evento ID',
            'marca_id' => 'Marca ID',
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
    public function getMarca()
    {
        return $this->hasOne(Marca::className(), ['id' => 'marca_id']);
    }
}
