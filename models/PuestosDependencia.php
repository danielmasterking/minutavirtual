<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "puestos_dependencia".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $codigo_dep
 */
class PuestosDependencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'puestos_dependencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'codigo_dep'], 'string', 'max' => 50],
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
            'codigo_dep' => 'Dependencia',
        ];
    }

    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'codigo_dep']);
    }
}
