<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zona_dependencia".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $area_dependencia_id
 *
 * @property Siniestro[] $siniestros
 * @property AreaDependencia $areaDependencia
 */
class ZonaDependencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zona_dependencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['area_dependencia_id'], 'integer'],
            [['nombre'], 'string', 'max' => 60],
            [['area_dependencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => AreaDependencia::className(), 'targetAttribute' => ['area_dependencia_id' => 'id']],
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
            'area_dependencia_id' => 'Area',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiniestros()
    {
        return $this->hasMany(Siniestro::className(), ['zona_dependencia_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(AreaDependencia::className(), ['id' => 'area_dependencia_id']);
    }
}
