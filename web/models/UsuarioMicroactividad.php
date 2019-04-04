<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_microactividad".
 *
 * @property integer $microactividad_id
 * @property string $usuario
 *
 * @property Microactividad $microactividad
 * @property Usuario $usuario0
 */
class UsuarioMicroactividad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_microactividad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['microactividad_id', 'usuario'], 'required'],
            [['microactividad_id'], 'integer'],
            [['usuario'], 'string', 'max' => 50],
            [['microactividad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Microactividad::className(), 'targetAttribute' => ['microactividad_id' => 'id']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'microactividad_id' => 'Microactividad ID',
            'usuario' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMicroactividad()
    {
        return $this->hasOne(Microactividad::className(), ['id' => 'microactividad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
}
