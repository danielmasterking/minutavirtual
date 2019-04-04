<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicio".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property DetalleServicio[] $detalleServicios
 */
class Servicio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'servicio';
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
    public function getDetalleServicios()
    {
        return $this->hasMany(DetalleServicio::className(), ['servicio_id' => 'id']);
    }
}
