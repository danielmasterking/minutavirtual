<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_gestion_riesgo".
 *
 * @property integer $id
 * @property integer $id_consulta
 * @property integer $id_respuesta
 * @property string $observaciones
 * @property string $planes_de_accion
 */
class DetalleGestionRiesgo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_gestion_riesgo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_consulta', 'id_respuesta'], 'integer'],
            [['observaciones', 'planes_de_accion'], 'string'],
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
            'id_respuesta' => 'Id Respuesta',
            'observaciones' => 'Observaciones',
            'planes_de_accion' => 'Planes De Accion',
        ];
    }
}
