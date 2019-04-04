<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "novedad_categoria_visita".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $categoria_visita_id
 * @property integer $criterio
 *
 * @property DetalleVisitaDia[] $detalleVisitaDias
 * @property CategoriaVisita $categoriaVisita
 * @property ValorNovedad[] $valorNovedads
 */
class NovedadCategoriaVisita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'novedad_categoria_visita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'categoria_visita_id'], 'required'],
            [['categoria_visita_id', 'criterio'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
            [['categoria_visita_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaVisita::className(), 'targetAttribute' => ['categoria_visita_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'categoria_visita_id' => 'Categoria Visita ID',
            'criterio' => 'Criterio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleVisitaDias()
    {
        return $this->hasMany(DetalleVisitaDia::className(), ['novedad_categoria_visita_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriaVisita()
    {
        return $this->hasOne(CategoriaVisita::className(), ['id' => 'categoria_visita_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValorNovedades()
    {
        return $this->hasMany(ValorNovedad::className(), ['novedad_categoria_visita_id' => 'id']);
    }
}
