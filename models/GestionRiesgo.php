<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_riesgo".
 *
 * @property integer $id
 * @property integer $id_centro_costo
 * @property string $fecha
 */
class GestionRiesgo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_riesgo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_centro_costo'], 'integer'],
            [['fecha'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_centro_costo' => 'Id Centro Costo',
            'fecha' => 'Fecha',
        ];
    }
}
