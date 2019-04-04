<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "material_merma".
 *
 * @property integer $id
 * @property string $material
 * @property integer $cantidad
 * @property string $valor
 * @property integer $merma_id
 *
 * @property Merma $merma
 */
class MaterialMerma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material_merma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material', 'merma_id'], 'required'],
            [['cantidad', 'merma_id'], 'integer'],
            [['valor'], 'number'],
            [['material'], 'string', 'max' => 100],
            [['merma_id'], 'exist', 'skipOnError' => true, 'targetClass' => Merma::className(), 'targetAttribute' => ['merma_id' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerma()
    {
        return $this->hasOne(Merma::className(), ['id' => 'merma_id']);
    }
}
