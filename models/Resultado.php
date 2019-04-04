<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultado".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property DetalleVisitaDia[] $detalleVisitaDias
 * @property ValorNovedad[] $valorNovedads
 */
class Resultado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 45],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleVisitaDias()
    {
        return $this->hasMany(DetalleVisitaDia::className(), ['resultado_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValorNovedads()
    {
        return $this->hasMany(ValorNovedad::className(), ['resultado_id' => 'id']);
    }
}
