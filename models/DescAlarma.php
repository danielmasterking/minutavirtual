<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "desc_alarma".
 *
 * @property integer $id
 * @property string $descripcion
 * @property integer $id_tipo_alarma
 */
class DescAlarma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'desc_alarma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'id_tipo_alarma',*/'descripcion'], 'required'],
            [['id_tipo_alarma'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'id_tipo_alarma' => 'Tipo Alarma',
        ];
    }


    public function getAlarma_tipo()
    {
        return $this->hasOne(TipoAlarma::className(), ['id' => 'id_tipo_alarma']);
    }

}
