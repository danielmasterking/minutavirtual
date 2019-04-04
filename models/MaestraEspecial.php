<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maestra_especial".
 *
 * @property integer $id
 * @property string $texto_breve
 * @property string $imputacion
 * @property string $material
  * @property integer $precio
 */
class MaestraEspecial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maestra_especial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['texto_breve', 'material'], 'required'],
            [['texto_breve'], 'string', 'max' => 200],
            [['imputacion'], 'string', 'max' => 5],
            [['material'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'texto_breve' => 'Texto Breve',
            'imputacion' => 'Imputacion',
            'material' => 'Material',
			'precio' => 'Precio',
        ];
    }
}
