<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "foto_merma".
 *
 * @property integer $id
 * @property string $imagen
 * @property integer $merma_id
 */
class FotoMerma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foto_merma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imagen', 'merma_id'], 'required'],
            [['merma_id'], 'integer'],
            [['imagen'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imagen' => 'Imagen',
            'merma_id' => 'Merma ID',
        ];
    }
}
