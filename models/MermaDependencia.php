<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merma_dependencia".
 *
 * @property integer $merma_id
 * @property string $centro_costo_codigo
 */
class MermaDependencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merma_dependencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merma_id', 'centro_costo_codigo'], 'required'],
            [['merma_id'], 'integer'],
            [['centro_costo_codigo'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'merma_id' => 'Merma ID',
            'centro_costo_codigo' => 'Centro Costo Codigo',
        ];
    }
	
    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
