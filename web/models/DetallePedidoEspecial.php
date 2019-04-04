<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_pedido_especial".
 *
 * @property integer $id
 * @property string $producto_sugerido
 * @property integer $cantidad
 * @property string $proveedor_sugerido
 * @property string $precio_sugerido
 * @property string $precio_neto
 * @property string $observaciones
 * @property string $archivo
 * @property integer $maestra_especial_id
 *
 * @property MaestraEspecial $maestraEspecial
 */
class DetallePedidoEspecial extends \yii\db\ActiveRecord
{
    
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_pedido_especial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['maestra_especial_id','pedido_id'], 'required'],
			[['fecha_revision_coordinador','fecha_revision_tecnica','fecha_revision_financiera'], 'safe'],
            [['cantidad', 'maestra_especial_id','pedido_id','id_pedido','posicion'], 'integer'],
            [['precio_sugerido'], 'number'],
            [['precio_neto'], 'number'],
			[['cebe'], 'string', 'max' => 10],
			[['orden_compra'], 'string', 'max' => 30], 
			[['dep'], 'string', 'max' => 150],
			[['proveedor'], 'string', 'max' => 80],
            [['motivo_rechazo','observacion_coordinador','observacion_tecnica','observacion_financiera','producto_sugerido', 'proveedor_sugerido', 'observaciones'], 'string', 'max' => 200],
            [['archivo'], 'string', 'max' => 500],
			[['codigo_activo','orden_interna','cuenta_contable'], 'string', 'max' => 20],
			[['estado','imputacion'], 'string', 'max' => 1],
            [['maestra_especial_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaestraEspecial::className(), 'targetAttribute' => ['maestra_especial_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'producto_sugerido' => 'Producto Sugerido',
            'cantidad' => 'Cantidad',
            'proveedor_sugerido' => 'Proveedor Sugerido',
            'precio_sugerido' => 'Precio Sugerido',
            'precio_neto' => 'Precio Neto',
            'observaciones' => 'Observaciones',
            'archivo' => 'Archivo',
			'estado' => 'Estado',
			'estado' => 'Imputación',
			'codigo_activo' => 'Código activo',
            'maestra_especial_id' => 'Maestra Especial',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaestra()
    {
        return $this->hasOne(MaestraEspecial::className(), ['id' => 'maestra_especial_id']);
    }
	
	 public function getPedido()
    {
        return $this->hasOne(Pedido::className(), ['id' => 'pedido_id']);
    }
}
