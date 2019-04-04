<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "centro_distrito".
 *
 * @property integer $distrito_id
 * @property string $centro_costo_codigo
 *
 * @property Distrito $distrito
 * @property CentroCosto $centroCostoCodigo
 */
class CentroDistrito extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'centro_distrito';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['distrito_id', 'centro_costo_codigo'], 'required'],
            [['distrito_id'], 'integer'],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['distrito_id'], 'exist', 'skipOnError' => true, 'targetClass' => Distrito::className(), 'targetAttribute' => ['distrito_id' => 'id']],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'distrito_id' => 'Distrito ID',
            'centro_costo_codigo' => 'Centro Costo Codigo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrito()
    {
        return $this->hasOne(Distrito::className(), ['id' => 'distrito_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
