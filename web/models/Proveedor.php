<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proveedor".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 *
 * @property MaestraProveedor[] $maestraProveedors
 */
class Proveedor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proveedor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'nombre'], 'required'],
            [['codigo'], 'string', 'max' => 10],
            [['nombre'], 'string', 'max' => 45],
			[['detalle'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'nombre' => 'Empresa',
			'detalle' => 'Tipo de suministro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaestraProveedors()
    {
        return $this->hasMany(MaestraProveedor::className(), ['proveedor_id' => 'id']);
    }
}
