<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comite_cordinador".
 *
 * @property integer $comite_id
 * @property string $usuario
 *
 * @property Comite $comite
 * @property Usuario $usuario0
 */
class ComiteCordinador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comite_cordinador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comite_id', 'usuario'], 'required'],
            [['comite_id'], 'integer'],
            [['usuario'], 'string', 'max' => 50],
            [['comite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comite::className(), 'targetAttribute' => ['comite_id' => 'id']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comite_id' => 'Comite ID',
            'usuario' => 'Usuario',
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
    public function getUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
}
