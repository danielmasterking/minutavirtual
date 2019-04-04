<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_dependencia".
 *
 * @property string $usuario
 * @property string $centro_costo_codigo
 *
 * @property Usuario $usuario0
 * @property CentroCosto $centroCostoCodigo
 */
class UsuarioDependencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_dependencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'centro_costo_codigo'], 'required'],
            [['usuario'], 'string', 'max' => 50],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'centro_costo_codigo' => 'Centro Costo Codigo',
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
    public function getCentroCostoCodigo()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
