<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "puesto".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $servicio_id
 *
 * @property Servicio $servicio
 */
class Puesto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'puesto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'servicio_id'], 'required'],
            [['servicio_id'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicio::className(), 'targetAttribute' => ['servicio_id' => 'id']],
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
            'servicio_id' => 'Servicio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicio()
    {
        return $this->hasOne(Servicio::className(), ['id' => 'servicio_id']);
    }
}
