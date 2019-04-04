<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prefactura_fija".
 *
 * @property integer $id
 * @property string $mes
 * @property string $ano
 * @property string $usuario
 * @property string $centro_costo_codigo
 * @property string $empresa
 * @property string $created
 * @property string $updated
 *
 * @property DetallePrefacturaFija[] $detallePrefacturaFijas
 * @property Usuario $usuario0
 * @property CentroCosto $centroCostoCodigo
 * @property Empresa $empresa0
 */
class PrefacturaFija extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prefactura_fija';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mes', 'ano', 'usuario', 'centro_costo_codigo', 'empresa', 'created', 'updated'], 'required'],
            [['created', 'updated'], 'safe'],
            [['mes'], 'string', 'max' => 2],
            [['ano'], 'string', 'max' => 4],
            [['usuario'], 'string', 'max' => 50],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['empresa'], 'string', 'max' => 10],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
            [['empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['empresa' => 'nit']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mes' => 'MES DE FACTURACION',
            'ano' => 'AÑO',
            'usuario' => 'Usuario',
            'centro_costo_codigo' => 'DEPENDENCIA',
            'empresa' => 'EMPRESA DE SEGURIDAD',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallePrefacturaFijas()
    {
        return $this->hasMany(DetallePrefacturaFija::className(), ['prefactura_fija_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['nit' => 'empresa']);
    }
}
