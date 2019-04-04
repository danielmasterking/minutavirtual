<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inconsistencia_general".
 *
 * @property integer $id
 * @property string $material_1
 * @property string $material_2
 * @property integer $maestra_proveedor_id
 *
 * @property MaestraProveedor $maestraProveedor
 */
class InconsistenciaGeneral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inconsistencia_general';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_1', 'material_2', 'maestra_proveedor_id'], 'required'],
            [['maestra_proveedor_id'], 'integer'],
            [['material_1', 'material_2'], 'string', 'max' => 45],
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
            'material_1' => 'Material 1',
            'material_2' => 'Material 2',
            'maestra_proveedor_id' => 'Maestra',
			'descripcion' => 'Descripción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaestraProveedor()
    {
        return $this->hasOne(MaestraProveedor::className(), ['id' => 'maestra_proveedor_id']);
    }
}
