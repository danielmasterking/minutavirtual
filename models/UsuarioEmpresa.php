<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_empresa".
 *
 * @property string $usuario
 * @property string $nit
 *
 * @property Usuario $usuario0
 * @property Empresa $nit0
 */
class UsuarioEmpresa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_empresa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'nit'], 'required'],
            [['usuario'], 'string', 'max' => 50],
            [['nit'], 'string', 'max' => 10],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
            [['nit'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['nit' => 'nit']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'nit' => 'Nit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['nit' => 'nit']);
    }
}
