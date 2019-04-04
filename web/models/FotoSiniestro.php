<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "foto_siniestro".
 *
 * @property integer $id
 * @property string $imagen
 * @property integer $siniestro_id
 *
 * @property Siniestro $siniestro
 */
class FotoSiniestro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foto_siniestro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imagen', 'siniestro_id'], 'required'],
            [['siniestro_id'], 'integer'],
            [['imagen'], 'string', 'max' => 500],
            [['siniestro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Siniestro::className(), 'targetAttribute' => ['siniestro_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imagen' => 'Imagen',
            'siniestro_id' => 'Siniestro ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiniestro()
    {
        return $this->hasOne(Siniestro::className(), ['id' => 'siniestro_id']);
    }
}
