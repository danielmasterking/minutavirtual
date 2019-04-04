<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inconsistencia_especifica".
 *
 * @property integer $id
 * @property string $material_1
 * @property string $material_2
 * @property string $centro_costo_codigo
 * @property integer $maestra_proveedor_id
 *
 * @property MaestraProveedor $maestraProveedor
 */
class InconsistenciaEspecifica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inconsistencia_especifica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_1', 'centro_costo_codigo', 'maestra_proveedor_id'], 'required'],
            [['maestra_proveedor_id'], 'integer'],
            [['material_1', 'material_2'], 'string', 'max' => 45],
            [['centro_costo_codigo'], 'string', 'max' => 15],
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
            'centro_costo_codigo' => 'Dependencia',
            'maestra_proveedor_id' => 'Maestra',
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
	
    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
	
	
}
