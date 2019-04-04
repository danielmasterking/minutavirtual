<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "valor_novedad".
 *
 * @property integer $id
 * @property integer $novedad_categoria_visita_id
 * @property integer $resultado_id
 *
 * @property MensajeNovedad[] $mensajeNovedads
 * @property NovedadCategoriaVisita $novedadCategoriaVisita
 * @property Resultado $resultado
 */
class ValorNovedad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'valor_novedad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['novedad_categoria_visita_id', 'resultado_id'], 'required'],
            [['novedad_categoria_visita_id', 'resultado_id'], 'integer'],
            [['novedad_categoria_visita_id'], 'exist', 'skipOnError' => true, 'targetClass' => NovedadCategoriaVisita::className(), 'targetAttribute' => ['novedad_categoria_visita_id' => 'id']],
            [['resultado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resultado::className(), 'targetAttribute' => ['resultado_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'novedad_categoria_visita_id' => 'Novedad Categoria Visita ID',
            'resultado_id' => 'Resultado ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajeNovedades()
    {
        return $this->hasMany(MensajeNovedad::className(), ['valor_novedad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedadCategoriaVisita()
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
}
