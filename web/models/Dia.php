<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dia".
 *
 * @property integer $id
 * @property integer $total
 * @property integer $festivos
 * @property string $ano
 */
class Dia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total', 'festivos', 'ano'], 'required'],
            [['total', 'festivos'], 'integer'],
            [['ano'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'total' => 'Total',
            'festivos' => 'Festivos',
            'ano' => 'Año',
        ];
    }
}
