<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "responsable".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $email
 * @property string $centro_costo_codigo
 * @property string $telefono
 * @property string $cargo
 *
 * @property CentroCosto $centroCostoCodigo
 */
class Responsable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'responsable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'email', 'centro_costo_codigo'], 'required'],
            [['nombre', 'cargo'], 'string', 'max' => 80],
            [['email'], 'string', 'max' => 100],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['telefono'], 'string', 'max' => 45],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
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
            'email' => 'Email',
            'centro_costo_codigo' => 'Centro Costo Codigo',
            'telefono' => 'Telefono',
            'cargo' => 'Cargo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentroCostoCodigo()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
