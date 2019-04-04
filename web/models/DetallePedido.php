<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_pedido".
 *
 * @property integer $id
 * @property integer $detalle_maestra_id
 * @property integer $pedido_id
 * @property string $estado
 * @property integer $cantidad
 * @property integer $precio_neto
 * @property string $observaciones
 * @property string $codigo_activo
 * @property string $imputacion
 * @property string $motivo_rechazo
 *
 * @property AuditoriaPedido[] $auditoriaPedidos
 * @property DetalleMaestra $detalleMaestra
 * @property Pedido $pedido
 */
class DetallePedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_pedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detalle_maestra_id', 'pedido_id'], 'required'],
            [['precio_neto'], 'required'],
            [['producto','pedido'], 'safe'],
			[['fecha_revision_coordinador','fecha_revision_tecnica','fecha_revision_financiera'], 'safe'],
            [['detalle_maestra_id', 'pedido_id', 'cantidad','id_pedido','posicion'], 'integer'],
            [['estado', 'imputacion','ordinario'], 'string', 'max' => 1],
			[['cebe'], 'string', 'max' => 10],
			[['orden_compra'], 'string', 'max' => 30],
			[['dep'], 'string', 'max' => 150],
            [['proveedor'], 'string', 'max' => 80],
			[['motivo_rechazo','observaciones'], 'string', 'max' => 200],
			[['observacion_coordinador','observacion_tecnica','observacion_financiera'], 'string', 'max' => 100],
            [['codigo_activo','orden_interna','cuenta_contable'], 'string', 'max' => 20],
            [['detalle_maestra_id'], 'exist', 'skipOnError' => true, 'targetClass' => DetalleMaestra::className(), 'targetAttribute' => ['detalle_maestra_id' => 'id']],
            [['pedido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pedido::className(), 'targetAttribute' => ['pedido_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detalle_maestra_id' => 'Detalle Maestra ID',
            'pedido_id' => 'Pedido',
            'estado' => 'Estado',
            'cantidad' => 'Cantidad',
            'precio_neto' => 'Precio Neto',
            'observaciones' => 'Observaciones',
            'codigo_activo' => 'Codigo Activo',
            'imputacion' => 'Imputación',
            'motivo_rechazo' => 'Motivo Rechazo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuditoriaPedidos()
    {
        return $this->hasMany(AuditoriaPedido::className(), ['detalle_pedido_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(DetalleMaestra::className(), ['id' => 'detalle_maestra_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedido()
    {
        return $this->hasOne(Pedido::className(), ['id' => 'pedido_id']);
    }
}
