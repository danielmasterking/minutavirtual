<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_visita_seccion".
 *
 * @property integer $id
 * @property integer $seccion_id
 * @property integer $detalle_visita_dia_id
 *
 * @property Seccion $seccion
 * @property DetalleVisitaDia $detalleVisitaDia
 */
class DetalleVisitaSeccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_visita_seccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seccion_id', 'detalle_visita_dia_id'], 'required'],
            [['seccion_id', 'detalle_visita_dia_id'], 'integer'],
            [['seccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Seccion::className(), 'targetAttribute' => ['seccion_id' => 'id']],
            [['detalle_visita_dia_id'], 'exist', 'skipOnError' => true, 'targetClass' => DetalleVisitaDia::className(), 'targetAttribute' => ['detalle_visita_dia_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'seccion_id' => 'Seccion ID',
            'detalle_visita_dia_id' => 'Detalle Visita Dia ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeccion()
    {
        return $this->hasOne(Seccion::className(), ['id' => 'seccion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleVisitaDia()
    {
        return $this->hasOne(DetalleVisitaDia::className(), ['id' => 'detalle_visita_dia_id']);
    }
}
