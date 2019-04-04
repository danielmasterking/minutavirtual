<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maestra_zona".
 *
 * @property integer $zona_id
 * @property integer $maestra_proveedor_id
 *
 * @property Zona $zona
 * @property MaestraProveedor $maestraProveedor
 */
class MaestraZona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maestra_zona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zona_id', 'maestra_proveedor_id'], 'required'],
            [['zona_id', 'maestra_proveedor_id'], 'integer'],
            [['zona_id'], 'exist', 'skipOnError' => true, 'targetClass' => Zona::className(), 'targetAttribute' => ['zona_id' => 'id']],
            [['maestra_proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaestraProveedor::className(), 'targetAttribute' => ['maestra_proveedor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'zona_id' => 'Zona ID',
            'maestra_proveedor_id' => 'Maestra Proveedor ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZona()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaestraProveedor()
    {
        return $this->hasOne(MaestraProveedor::className(), ['id' => 'maestra_proveedor_id']);
    }
}
