<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evento_dependencia".
 *
 * @property string $centro_costo_codigo
 * @property integer $cantidad_apoyo
 * @property integer $evento_id
 *
 * @property CentroCosto $centroCostoCodigo
 * @property Evento $evento
 */
class EventoDependencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evento_dependencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['centro_costo_codigo', 'evento_id'], 'required'],
            [['cantidad_apoyo', 'evento_id'], 'integer'],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
            [['evento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['evento_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'centro_costo_codigo' => 'Centro Costo Codigo',
            'cantidad_apoyo' => 'Cantidad Apoyo',
            'evento_id' => 'Evento ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentroCostoCodigo()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvento()
    {
        return $this->hasOne(Evento::className(), ['id' => 'evento_id']);
    }
}
