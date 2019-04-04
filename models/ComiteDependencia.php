<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comite_dependencia".
 *
 * @property integer $comite_id
 * @property string $centro_costo_codigo
 *
 * @property Comite $comite
 * @property CentroCosto $centroCostoCodigo
 */
class ComiteDependencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comite_dependencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comite_id', 'centro_costo_codigo'], 'required'],
            [['comite_id'], 'integer'],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['comite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comite::className(), 'targetAttribute' => ['comite_id' => 'id']],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comite_id' => 'Comite ID',
            'centro_costo_codigo' => 'Centro Costo Codigo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComite()
    {
        return $this->hasOne(Comite::className(), ['id' => 'comite_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
