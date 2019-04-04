<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "precios_monitoreo".
 *
 * @property integer $id
 * @property integer $id_empresa
 * @property integer $id_sistema_monitoreo
 * @property string $valor_unitario
 * @property string $ano
 */
class PreciosMonitoreo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'precios_monitoreo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_empresa', 'id_sistema_monitoreo'], 'integer'],
            [['ano'], 'safe'],
            [['valor_unitario'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_empresa' => 'Empresa de seguridad',
            'id_sistema_monitoreo' => 'Sistema Monitoreado',
            'valor_unitario' => 'Valor Unitario',
            'ano' => 'Año',
        ];
    }


    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['nit' => 'id_empresa']);
    }

    public function getSistemamonitoreo()
    {
        return $this->hasOne(SistemaMonitoreado::className(), ['id' => 'id_sistema_monitoreo']);
    }

}
