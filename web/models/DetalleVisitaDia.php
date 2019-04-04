<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_visita_dia".
 *
 * @property integer $id
 * @property integer $visita_dia_id
 * @property integer $novedad_categoria_visita_id
 * @property integer $resultado_id
 * @property string $observacion
 * @property integer $mensaje_novedad_id
 *
 * @property VisitaDia $visitaDia
 * @property NovedadCategoriaVisita $novedadCategoriaVisita
 * @property Resultado $resultado
 * @property MensajeNovedad $mensajeNovedad
 */
class DetalleVisitaDia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_visita_dia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visita_dia_id', 'novedad_categoria_visita_id', 'resultado_id', 'mensaje_novedad_id'], 'required'],
            [['visita_dia_id', 'novedad_categoria_visita_id', 'resultado_id', 'mensaje_novedad_id'], 'integer'],
            [['observacion'], 'string', 'max' => 80],
            [['visita_dia_id'], 'exist', 'skipOnError' => true, 'targetClass' => VisitaDia::className(), 'targetAttribute' => ['visita_dia_id' => 'id']],
            [['novedad_categoria_visita_id'], 'exist', 'skipOnError' => true, 'targetClass' => NovedadCategoriaVisita::className(), 'targetAttribute' => ['novedad_categoria_visita_id' => 'id']],
            [['resultado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resultado::className(), 'targetAttribute' => ['resultado_id' => 'id']],
            [['mensaje_novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => MensajeNovedad::className(), 'targetAttribute' => ['mensaje_novedad_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visita_dia_id' => 'Visita Dia ID',
            'novedad_categoria_visita_id' => 'Novedad Categoria Visita ID',
            'resultado_id' => 'Resultado ID',
            'observacion' => 'Observacion',
            'mensaje_novedad_id' => 'Mensaje Novedad ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitaDia()
    {
        return $this->hasOne(VisitaDia::className(), ['id' => 'visita_dia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedad()
    {
        return $this->hasOne(NovedadCategoriaVisita::className(), ['id' => 'novedad_categoria_visita_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultado()
    {
        return $this->hasOne(Resultado::className(), ['id' => 'resultado_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajeNovedad()
    {
        return $this->hasOne(MensajeNovedad::className(), ['id' => 'mensaje_novedad_id']);
    }
	
	 public function getSeccion()
    {
        return $this->hasOne(DetalleVisitaSeccion::className(), ['detalle_visita_dia_id' => 'id']);
    }
}
