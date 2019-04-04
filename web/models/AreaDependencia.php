<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area_dependencia".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property Siniestro[] $siniestros
 */
class AreaDependencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area_dependencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 60],
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
    public function getSiniestros()
    {
        return $this->hasMany(Siniestro::className(), ['area_dependencia_id' => 'id']);
    }
}
