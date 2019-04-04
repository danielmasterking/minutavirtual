<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periodicidad".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property Metrica[] $metricas
 */
class Periodicidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'periodicidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
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
    public function getMetricas()
    {
        return $this->hasMany(Metrica::className(), ['periodicidad_id' => 'id']);
    }
}
