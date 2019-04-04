<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "foto_evento".
 *
 * @property integer $id
 * @property integer $evento_id
 * @property string $imagen
 *
 * @property Evento $evento
 */
class FotoEvento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foto_evento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['evento_id', 'imagen'], 'required'],
            [['evento_id'], 'integer'],
            [['imagen'], 'string', 'max' => 500],
            [['evento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['evento_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'evento_id' => 'Evento ID',
            'imagen' => 'Imagen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvento()
    {
        return $this->hasOne(Evento::className(), ['id' => 'evento_id']);
    }
}
