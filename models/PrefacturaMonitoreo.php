<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prefactura_monitoreo".
 *
 * @property integer $id
 * @property string $monitoreo
 * @property integer $id_sistema_monitoreo
 * @property integer $cantidad_servicios
 * @property string $valor_unitario
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $valor_total
 * @property string $centro_costo_codigo
 * @property integer $id_empresa
 * @property integer $id_prefactura_electronica
 */
class PrefacturaMonitoreo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prefactura_monitoreo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sistema_monitoreo', 'cantidad_servicios', 'id_empresa', 'id_prefactura_electronica'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['monitoreo'], 'string', 'max' => 50],
            [['valor_unitario', 'valor_total', 'centro_costo_codigo'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'monitoreo' => 'Monitoreo',
            'id_sistema_monitoreo' => 'Id Sistema Monitoreo',
            'cantidad_servicios' => 'Cantidad Servicios',
            'valor_unitario' => 'Valor Unitario',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'valor_total' => 'Valor Total',
            'centro_costo_codigo' => 'Centro Costo Codigo',
            'id_empresa' => 'Id Empresa',
            'id_prefactura_electronica' => 'Id Prefactura Electronica',
        ];
    }
}
