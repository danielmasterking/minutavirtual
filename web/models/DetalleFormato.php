<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_formato".
 *
 * @property integer $id
 * @property integer $formato_id
 *
 * @property Formato $formato
 */
class DetalleFormato extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_formato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['formato_id'], 'required'],
            [['formato_id'], 'integer'],
            [['formato_id'], 'exist', 'skipOnError' => true, 'targetClass' => Formato::className(), 'targetAttribute' => ['formato_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'formato_id' => 'Formato ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormato()
    {
        return $this->hasOne(Formato::className(), ['id' => 'formato_id']);
    }
}
