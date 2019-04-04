<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "foto_incidente".
 *
 * @property integer $id
 * @property string $imagen
 * @property integer $incidente_id
 */
class FotoIncidente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foto_incidente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imagen', 'incidente_id'], 'required'],
            [['incidente_id'], 'integer'],
            [['imagen'], 'string', 'max' => 500],
			[['detalle'], 'string', 'max' => 1000],
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
            'incidente_id' => 'Incidente ID',
        ];
    }
}
