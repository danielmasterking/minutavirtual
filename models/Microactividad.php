<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "microactividad".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $peso
 * @property integer $macroactividad_id
 *
 * @property Macroactividad $macroactividad
 */
class Microactividad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'microactividad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peso', 'macroactividad_id'], 'integer'],
            [['macroactividad_id'], 'required'],
            [['nombre'], 'string', 'max' => 80],
			[['detalle'], 'string', 'max' => 400],
            [['macroactividad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Macroactividad::className(), 'targetAttribute' => ['macroactividad_id' => 'id']],
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
            'macroactividad_id' => 'Macroactividad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMacroactividad()
    {
        return $this->hasOne(Macroactividad::className(), ['id' => 'macroactividad_id']);
    }
}
