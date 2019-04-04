<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inconsistencia_marca".
 *
 * @property integer $id
 * @property integer $marca_id
 * @property string $material
 * @property string $descripcion
 * @property integer $maestra_proveedor_id
 *
 * @property Marca $marca
 * @property MaestraProveedor $maestraProveedor
 */
class InconsistenciaMarca extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inconsistencia_marca';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['marca_id', 'material', 'maestra_proveedor_id'], 'required'],
            [['marca_id', 'maestra_proveedor_id'], 'integer'],
            [['material'], 'string', 'max' => 45],
            [['descripcion'], 'string', 'max' => 200],
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
            'id' => 'ID',
            'marca_id' => 'Marca',
            'material' => 'Material',
            'descripcion' => 'Descripción',
            'maestra_proveedor_id' => 'Maestra',
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
    public function getMaestra()
    {
        return $this->hasOne(MaestraProveedor::className(), ['id' => 'maestra_proveedor_id']);
    }
}
