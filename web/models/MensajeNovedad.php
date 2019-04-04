<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensaje_novedad".
 *
 * @property integer $id
 * @property integer $valor_novedad_id
 * @property string $mensaje
 *
 * @property DetalleVisitaDia[] $detalleVisitaDias
 * @property ValorNovedad $valorNovedad
 */
class MensajeNovedad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mensaje_novedad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor_novedad_id', 'mensaje'], 'required'],
            [['valor_novedad_id','criterio'], 'integer'],
            [['mensaje'], 'string', 'max' => 80],
            [['valor_novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => ValorNovedad::className(), 'targetAttribute' => ['valor_novedad_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor_novedad_id' => 'Valor Novedad',
            'mensaje' => 'Mensaje',
			'criterio' => 'Criterio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleVisitaDias()
    {
        return $this->hasMany(DetalleVisitaDia::className(), ['mensaje_novedad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValorNovedad()
    {
        return $this->hasOne(ValorNovedad::className(), ['id' => 'valor_novedad_id']);
    }
}
