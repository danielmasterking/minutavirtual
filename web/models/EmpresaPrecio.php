<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresa_precio".
 *
 * @property string $nit
 * @property string $precio
 * @property integer $tipo_alarma_id
 * @property integer $id
 *
 * @property Empresa $nit0
 * @property TipoAlarma $tipoAlarma
 */
class EmpresaPrecio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa_precio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nit', 'precio', 'tipo_alarma_id'], 'required'],
            [['precio'], 'number'],
            [['tipo_alarma_id'], 'integer'],
            [['nit'], 'string', 'max' => 10],
            [['nit'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['nit' => 'nit']],
            [['tipo_alarma_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoAlarma::className(), 'targetAttribute' => ['tipo_alarma_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nit' => 'Empresa',
            'precio' => 'Precio',
            'tipo_alarma_id' => 'Tipo Alarma',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmp()
    {
        return $this->hasOne(Empresa::className(), ['nit' => 'nit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoAlarma()
    {
        return $this->hasOne(TipoAlarma::className(), ['id' => 'tipo_alarma_id']);
    }
}
