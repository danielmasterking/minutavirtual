<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seccion".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $criterio
 *
 * @property DetalleVisitaSeccion[] $detalleVisitaSeccions
 */
class Seccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seccion';
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
    public function getDetalleVisitaSeccions()
    {
        return $this->hasMany(DetalleVisitaSeccion::className(), ['seccion_id' => 'id']);
    }
}
