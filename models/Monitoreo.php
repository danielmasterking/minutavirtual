<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "monitoreo".
 *
 * @property integer $id
 * @property string $nit
 * @property integer $cantidad
 * @property string $valor_total
 * @property integer $tipo_alarma_id
 * @property string $centro_costo_codigo
 *
 * @property Empresa $nit0
 * @property TipoAlarma $tipoAlarma
 * @property CentroCosto $centroCostoCodigo
 */
class Monitoreo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monitoreo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nit', 'cantidad', 'valor_total', 'tipo_alarma_id', 'centro_costo_codigo'], 'required'],
            [['cantidad', 'tipo_alarma_id'], 'integer'],
            [['valor_total'], 'number'],
            [['nit'], 'string', 'max' => 10],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['nit'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['nit' => 'nit']],
            [['tipo_alarma_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoAlarma::className(), 'targetAttribute' => ['tipo_alarma_id' => 'id']],
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
            'nit' => 'Nit',
            'cantidad' => 'Cantidad',
            'valor_total' => 'Valor Total',
            'tipo_alarma_id' => 'Tipo Alarma ID',
            'centro_costo_codigo' => 'Centro Costo Codigo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNit0()
    {
        return $this->hasOne(Empresa::className(), ['nit' => 'nit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoAlarma()
    {
        return $this->hasOne(TipoAlarma::className(), ['id' => 'tipo_alarma_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentroCostoCodigo()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
