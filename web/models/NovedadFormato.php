<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "novedad_formato".
 *
 * @property integer $id
 * @property integer $novedad_id
 * @property string $op
 * @property string $numerador
 * @property integer $total
 *
 * @property Novedad $novedad
 */
class NovedadFormato extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'novedad_formato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['novedad_id'], 'required'],
            [['novedad_id', 'total'], 'integer'],
            [['op'], 'string', 'max' => 3],
            [['numerador'], 'string', 'max' => 40],
            [['novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Novedad::className(), 'targetAttribute' => ['novedad_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'novedad_id' => 'Novedad ID',
            'op' => 'Op',
            'numerador' => 'Numerador',
            'total' => 'Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedad()
    {
        return $this->hasOne(Novedad::className(), ['id' => 'novedad_id']);
    }
}
