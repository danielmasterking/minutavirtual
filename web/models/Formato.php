<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "formato".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $microactividad_id
 *
 * @property DetalleFormato[] $detalleFormatos
 * @property Microactividad $id0
 * @property FormatoRol[] $formatoRols
 */
class Formato extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'formato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'microactividad_id'], 'required'],
            [['microactividad_id'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Microactividad::className(), 'targetAttribute' => ['id' => 'id']],
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
            'microactividad_id' => 'Microactividad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleFormatos()
    {
        return $this->hasMany(DetalleFormato::className(), ['formato_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMicroactividad()
    {
        return $this->hasOne(Microactividad::className(), ['id' => 'microactividad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormatoRols()
    {
        return $this->hasMany(FormatoRol::className(), ['formato_id' => 'id']);
    }
}
