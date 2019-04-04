<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_usuarios".
 *
 * @property integer $id
 * @property string $usuario
 * @property string $fecha
 * @property string $hora_inicio
 * @property string $hora_fin
 */
class LogUsuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'hora_inicio', 'hora_fin'], 'safe'],
            [['usuario'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario' => 'Usuario',
            'fecha' => 'Fecha',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
        ];
    }
}
