<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_macroactividad".
 *
 * @property integer $macroactividad_id
 * @property string $usuario
 *
 * @property Macroactividad $macroactividad
 * @property Usuario $usuario0
 */
class UsuarioMacroactividad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_macroactividad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['macroactividad_id', 'usuario'], 'required'],
            [['macroactividad_id'], 'integer'],
            [['usuario'], 'string', 'max' => 50],
            [['macroactividad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Macroactividad::className(), 'targetAttribute' => ['macroactividad_id' => 'id']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'macroactividad_id' => 'Macroactividad ID',
            'usuario' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMacroactividad()
    {
        return $this->hasOne(Macroactividad::className(), ['id' => 'macroactividad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
}
