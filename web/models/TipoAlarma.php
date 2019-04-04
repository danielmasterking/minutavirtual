<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_alarma".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property EmpresaPrecio[] $empresaPrecios
 */
class TipoAlarma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_alarma';
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
    public function getEmpresaPrecios()
    {
        return $this->hasMany(EmpresaPrecio::className(), ['tipo_alarma_id' => 'id']);
    }
}
