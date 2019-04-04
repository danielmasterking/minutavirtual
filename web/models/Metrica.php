<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "metrica".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $peso
 * @property string $detalle
 * @property integer $meta
 * @property integer $periodicidad_id
 * @property integer $indicador_id
 *
 * @property Macroactividad[] $macroactividads
 * @property Periodicidad $periodicidad
 * @property Indicador $indicador
 */
class Metrica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'metrica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'periodicidad_id', 'indicador_id'], 'required'],
            [['peso', 'meta', 'periodicidad_id', 'indicador_id'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['detalle'], 'string', 'max' => 3000],
            [['periodicidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Periodicidad::className(), 'targetAttribute' => ['periodicidad_id' => 'id']],
            [['indicador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Indicador::className(), 'targetAttribute' => ['indicador_id' => 'id']],
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
            'peso' => 'Peso (%)',
            'detalle' => 'Detalle',
            'meta' => 'Meta',
            'periodicidad_id' => 'Periodicidad',
            'indicador_id' => 'Indicador',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMacroactividades()
    {
        return $this->hasMany(Macroactividad::className(), ['metrica_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodicidad()
    {
        return $this->hasOne(Periodicidad::className(), ['id' => 'periodicidad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicador()
    {
        return $this->hasOne(Indicador::className(), ['id' => 'indicador_id']);
    }
}
