<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proyecto_archivo".
 *
 * @property integer $id
 * @property integer $id_det_pedido
 * @property string $archivo
 * @property string $id_empresa
 */
class ProyectoArchivo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proyecto_archivo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_det_pedido'], 'integer'],
            [['archivo', 'id_empresa'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_det_pedido' => 'Id Det Pedido',
            'archivo' => 'Archivo',
            'id_empresa' => 'Empresa',
        ];
    }


    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['nit' => 'id_empresa']);
    }
}
