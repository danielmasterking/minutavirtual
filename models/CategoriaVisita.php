<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categoria_visita".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $criterio
 *
 * @property NovedadCategoriaVisita[] $novedadCategoriaVisitas
 */
class CategoriaVisita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categoria_visita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['criterio'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
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
            'criterio' => 'Criterio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedades()
    {
        return $this->hasMany(NovedadCategoriaVisita::className(), ['categoria_visita_id' => 'id']);
    }
}
