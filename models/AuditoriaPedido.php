<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auditoria_pedido".
 *
 * @property integer $id
 * @property integer $detalle_pedido_id
 * @property string $mensaje
 * @property string $fecha
 *
 * @property DetallePedido $detallePedido
 */
class AuditoriaPedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auditoria_pedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detalle_pedido_id', 'mensaje'], 'required'],
            [['detalle_pedido_id'], 'integer'],
            [['fecha'], 'safe'],
            [['mensaje'], 'string', 'max' => 250],
            [['detalle_pedido_id'], 'exist', 'skipOnError' => true, 'targetClass' => DetallePedido::className(), 'targetAttribute' => ['detalle_pedido_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detalle_pedido_id' => 'Detalle Pedido ID',
            'mensaje' => 'Mensaje',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallePedido()
    {
        return $this->hasOne(DetallePedido::className(), ['id' => 'detalle_pedido_id']);
    }
}
