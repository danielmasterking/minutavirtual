<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proyecto_estado_pedidos".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property ProyectoPedidoEspecial[] $proyectoPedidoEspecials
 * @property ProyectoPedidos[] $proyectoPedidos
 */
class ProyectoEstadoPedidos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proyecto_estado_pedidos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 64],
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
    public function getProyectoPedidoEspecials()
    {
        return $this->hasMany(ProyectoPedidoEspecial::className(), ['estado_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectoPedidos()
    {
        return $this->hasMany(ProyectoPedidos::className(), ['estado_id' => 'id']);
    }
}
