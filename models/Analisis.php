<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "analisis".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $descripcion
 * @property string $archivo
 * @property string $centro_costo_codigo
 *
 * @property CentroCosto $centroCostoCodigo
 */
class Analisis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'analisis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'centro_costo_codigo'], 'required'],
            [['fecha'], 'safe'],
            [['descripcion'], 'string', 'max' => 5000],
            [['archivo'], 'string', 'max' => 500],
            [['centro_costo_codigo'], 'string', 'max' => 15],
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
            'fecha' => 'Fecha',
            'descripcion' => 'Descripcion',
            'archivo' => 'Archivo',
            'centro_costo_codigo' => 'Centro Costo Codigo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentroCostoCodigo()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
