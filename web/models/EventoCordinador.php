<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evento_cordinador".
 *
 * @property integer $evento_id
 * @property string $usuario
 *
 * @property Evento $evento
 * @property Usuario $usuario0
 */
class EventoCordinador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evento_cordinador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['evento_id', 'usuario'], 'required'],
            [['evento_id'], 'integer'],
            [['usuario'], 'string', 'max' => 50],
            [['evento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['evento_id' => 'id']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'evento_id' => 'Evento ID',
            'usuario' => 'Usuario',
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
    public function getUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
}
