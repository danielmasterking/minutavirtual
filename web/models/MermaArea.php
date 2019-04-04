<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merma_area".
 *
 * @property integer $id
 * @property string $material
 * @property integer $cantidad
 * @property string $valor
 * @property integer $merma_id
 * @property integer $area_dependencia_id
 * @property integer $zona_dependencia_id
 *
 * @property Merma $merma
 * @property AreaDependencia $areaDependencia
 * @property ZonaDependencia $zonaDependencia
 */
class MermaArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merma_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cantidad', 'merma_id', 'area_dependencia_id', 'zona_dependencia_id'], 'integer'],
            [['valor'], 'number'],
            [['merma_id', 'area_dependencia_id', 'zona_dependencia_id'], 'required'],
            [['material'], 'string', 'max' => 400],
            [['merma_id'], 'exist', 'skipOnError' => true, 'targetClass' => Merma::className(), 'targetAttribute' => ['merma_id' => 'id']],
            [['area_dependencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => AreaDependencia::className(), 'targetAttribute' => ['area_dependencia_id' => 'id']],
            [['zona_dependencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZonaDependencia::className(), 'targetAttribute' => ['zona_dependencia_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material' => 'Material',
            'cantidad' => 'Cantidad',
            'valor' => 'Valor',
            'merma_id' => 'Merma ID',
            'area_dependencia_id' => 'Area Dependencia ID',
            'zona_dependencia_id' => 'Zona Dependencia ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerma()
    {
        return $this->hasOne(Merma::className(), ['id' => 'merma_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaDependencia()
    {
        return $this->hasOne(AreaDependencia::className(), ['id' => 'area_dependencia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZonaDependencia()
    {
        return $this->hasOne(ZonaDependencia::className(), ['id' => 'zona_dependencia_id']);
    }
}
