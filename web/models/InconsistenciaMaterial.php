<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inconsistencia_material".
 *
 * @property integer $id
 * @property integer $maestra_proveedor_id
 * @property string $material
 * @property string $descripcion
 *
 * @property MaestraProveedor $maestraProveedor
 */
class InconsistenciaMaterial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inconsistencia_material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['maestra_proveedor_id', 'material'], 'required'],
            [['maestra_proveedor_id'], 'integer'],
            [['material'], 'string', 'max' => 45],
            [['descripcion'], 'string', 'max' => 200],
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
            'maestra_proveedor_id' => 'Maestra',
            'material' => 'Material',
            'descripcion' => 'Descripción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaestra()
    {
        return $this->hasOne(MaestraProveedor::className(), ['id' => 'maestra_proveedor_id']);
    }
}
