<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "personas".
 *
 * @property integer $cedula
 * @property string $nombres
 * @property string $apellidos
 * @property string $sexo
 * @property string $telefono
 * @property string $celular
 * @property string $email
 * @property string $estado
 * @property string $observacion
 */
class Personas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cedula', 'nombres', 'apellidos','estado'], 'required'],
            //['email','email'],
            [['cedula'], 'unique','message' => 'Esta persona ya esta registrada'],
            [['cedula'], 'integer'],
            [['estado', 'observacion'], 'string'],
            [['nombres', 'apellidos', 'email'], 'string', 'max' => 50],
            [['sexo'], 'string', 'max' => 1],
            [['telefono', 'celular'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cedula' => 'Cedula',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'sexo' => 'Sexo',
            'telefono' => 'Telefono',
            'celular' => 'Celular',
            'email' => 'Email',
            'estado' => 'Estado',
            'observacion' => 'Observacion',
        ];
    }
}
