<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "help_consulta_gestion".
 *
 * @property integer $id
 * @property string $descripcion
 * @property integer $id_consulta_gestion
 * @property string $estado
 */
class HelpConsultaGestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'help_consulta_gestion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['id_consulta_gestion'], 'integer'],
            [['estado'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'id_consulta_gestion' => 'Id Consulta Gestion',
            'estado' => 'Estado',
        ];
    }
}
