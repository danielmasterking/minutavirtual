<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_ciudad".
 *
 * @property string $usuario
 * @property string $ciudad_codigo_dane
 *
 * @property Usuario $usuario0
 * @property Ciudad $ciudadCodigoDane
 */
class UsuarioCiudad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_ciudad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'ciudad_codigo_dane'], 'required'],
            [['usuario'], 'string', 'max' => 50],
            [['ciudad_codigo_dane'], 'string', 'max' => 8],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
            [['ciudad_codigo_dane'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['ciudad_codigo_dane' => 'codigo_dane']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'ciudad_codigo_dane' => 'Ciudad Codigo Dane',
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
    public function getCiudadCodigoDane()
    {
        return $this->hasOne(Ciudad::className(), ['codigo_dane' => 'ciudad_codigo_dane']);
    }
}
