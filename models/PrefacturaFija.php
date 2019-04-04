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
 * @property PrefacturaDispositivo[] $prefacturaDispositivos
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
            [['usuario','regional','ciudad','marca'], 'string', 'max' => 50],
            [['empresa'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mes' => 'Mes',
            'ano' => 'Año',
            'usuario' => 'Usuario',
            'centro_costo_codigo' => 'Dependencia',
            'empresa' => 'Empresa',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrefacturaDispositivos()
    {
        return $this->hasMany(PrefacturaDispositivo::className(), ['id_prefactura_fija' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['nit' => 'empresa']);
    }
}
