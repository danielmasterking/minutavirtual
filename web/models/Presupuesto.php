<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "presupuesto".
 *
 * @property integer $id
 * @property string $centro_costo_codigo
 * @property string $presupuesto_inicial
 * @property string $presupuesto_actual
 * @property string $estado_dependencia
 *
 * @property CentroCosto $centroCostoCodigo
 */
class Presupuesto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'presupuesto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['centro_costo_codigo'], 'required'],
			[['fecha_asignacion'], 'safe'],
            [['presupuesto_inicial', 'presupuesto_actual','presupuesto_seguridad','presupuesto_riesgo','presupuesto_actual','presupuesto_seguridad_actual'], 'number'],
            [['centro_costo_codigo'], 'string', 'max' => 15],
			 [['orden_interna'], 'string', 'max' => 12],
            [['estado_dependencia'], 'string', 'max' => 1],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'centro_costo_codigo' => 'Dependencia',
            'presupuesto_inicial' => 'Valor Presupuesto',
			'presupuesto_riesgo' => 'Valor presupuesto inicial riesgos',
			'presupuesto_seguridad' => 'Valor presupuesto inicial seguridad',
            'presupuesto_actual' => 'Total',
			'orden_interna' => 'Orden Interna',
            'estado_dependencia' => 'Estado Dependencia',
			'fecha_asignacion' => 'Fecha Finalización Desarrollo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
