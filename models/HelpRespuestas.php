<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "help_respuestas".
 *
 * @property integer $id
 * @property integer $id_consulta
 * @property string $cumple
 * @property string $no_cumple
 * @property string $en_proceso
 */
class HelpRespuestas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'help_respuestas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_consulta'], 'integer'],
            [['cumple', 'no_cumple', 'en_proceso'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_consulta' => 'Id Consulta',
            'cumple' => 'Cumple',
            'no_cumple' => 'No Cumple',
            'en_proceso' => 'En Proceso',
        ];
    }
}
