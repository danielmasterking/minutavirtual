<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jornada".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property string $nocturna
 */
class Jornada extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jornada';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'hora_inicio', 'hora_fin'], 'required'],
            [['nombre'], 'string', 'max' => 45],
            [['hora_inicio', 'hora_fin'], 'string', 'max' => 10],
            [['nocturna'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
            'nocturna' => 'Nocturna',
        ];
    }
}
