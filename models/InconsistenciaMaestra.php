<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inconsistencia_maestra".
 *
 * @property integer $id
 * @property string $material
 * @property string $descripcion
 * @property integer $maestra_proveedor_id
 *
 * @property MaestraProveedor $maestraProveedor
 */
class InconsistenciaMaestra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inconsistencia_maestra';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material', 'maestra_proveedor_id'], 'required'],
            [['maestra_proveedor_id'], 'integer'],
            [['material', 'descripcion'], 'string', 'max' => 45],
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
            'material' => 'Material',
            'descripcion' => 'Descripción',
            'maestra_proveedor_id' => 'Maestra',
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
