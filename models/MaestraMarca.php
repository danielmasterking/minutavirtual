<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maestra_marca".
 *
 * @property integer $marca_id
 * @property integer $maestra_proveedor_id
 *
 * @property Marca $marca
 * @property MaestraProveedor $maestraProveedor
 */
class MaestraMarca extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maestra_marca';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['marca_id', 'maestra_proveedor_id'], 'required'],
            [['marca_id', 'maestra_proveedor_id'], 'integer'],
            [['marca_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marca::className(), 'targetAttribute' => ['marca_id' => 'id']],
            [['maestra_proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaestraProveedor::className(), 'targetAttribute' => ['maestra_proveedor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'marca_id' => 'Marca ID',
            'maestra_proveedor_id' => 'Maestra Proveedor ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarca()
    {
        return $this->hasOne(Marca::className(), ['id' => 'marca_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaestraProveedor()
    {
        return $this->hasOne(MaestraProveedor::className(), ['id' => 'maestra_proveedor_id']);
    }
}
