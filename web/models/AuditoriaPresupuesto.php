<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auditoria_presupuesto".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $operacion
 * @property string $valor
 * @property string $centro_costo_codigo
 * @property string $usuario
 *
 * @property CentroCosto $centroCostoCodigo
 * @property Usuario $usuario0
 */
class AuditoriaPresupuesto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auditoria_presupuesto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'valor', 'centro_costo_codigo', 'usuario'], 'required'],
            [['fecha'], 'safe'],
            [['valor'], 'number'],
            [['operacion','area'], 'string', 'max' => 10],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['usuario'], 'string', 'max' => 50],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'operacion' => 'Operacion',
			'area' => 'Area',
            'valor' => 'Valor',
            'centro_costo_codigo' => 'Centro Costo Codigo',
            'usuario' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCentroCostoCodigo()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
}
