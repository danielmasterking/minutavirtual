<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "archivo_visita_mensual".
 *
 * @property integer $id
 * @property string $archivo
 * @property integer $visita_mensual_id
 *
 * @property VisitaMensual $visitaMensual
 */
class ArchivoVisitaMensual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'archivo_visita_mensual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['archivo', 'visita_mensual_id'], 'required'],
            [['visita_mensual_id'], 'integer'],
            [['archivo'], 'string', 'max' => 500],
            [['visita_mensual_id'], 'exist', 'skipOnError' => true, 'targetClass' => VisitaMensual::className(), 'targetAttribute' => ['visita_mensual_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'archivo' => 'Archivo',
            'visita_mensual_id' => 'Visita Mensual ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitaMensual()
    {
        return $this->hasOne(VisitaMensual::className(), ['id' => 'visita_mensual_id']);
    }
}
