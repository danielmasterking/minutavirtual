<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_distrito".
 *
 * @property string $usuario
 * @property integer $distrito_id
 *
 * @property Usuario $usuario0
 * @property Distrito $distrito
 */
class UsuarioDistrito extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_distrito';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'distrito_id'], 'required'],
            [['distrito_id'], 'integer'],
            [['usuario'], 'string', 'max' => 50],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
            [['distrito_id'], 'exist', 'skipOnError' => true, 'targetClass' => Distrito::className(), 'targetAttribute' => ['distrito_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'distrito_id' => 'Distrito ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrito()
    {
        return $this->hasOne(Distrito::className(), ['id' => 'distrito_id']);
    }
}
