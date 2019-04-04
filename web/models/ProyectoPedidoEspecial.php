<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proyecto_pedido_especial".
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
 * @property integer $proyecto_id
 * @property integer $estado_id
 * @property string $observacion_coordinador
 * @property string $motivo_rechazo
 * @property string $orden_interna_gasto
 * @property string $orden_interna_activo
 * @property string $tipo_presupuesto
 * @property string $fecha_revision_coordinador
 * @property string $created_on
 * @property string $repetido
 *
 * @property ProyectoEstadoPedidos $estado
 * @property MaestraEspecial $maestraEspecial
 * @property Proyectos $proyecto
 */
class ProyectoPedidoEspecial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proyecto_pedido_especial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cantidad', 'maestra_especial_id', 'proyecto_id', 'estado_id'], 'integer'],
            [['precio_sugerido', 'precio_neto'], 'number'],
            [['maestra_especial_id', 'proyecto_id', 'estado_id', 'created_on'], 'required'],
            [['fecha_revision_coordinador', 'created_on'], 'safe'],
            [['repetido'], 'string'],
            [['producto_sugerido', 'proveedor_sugerido', 'observaciones', 'observacion_coordinador', 'motivo_rechazo'], 'string', 'max' => 200],
            [['cebe'], 'string', 'max' => 10],
            [['archivo'], 'string', 'max' => 500],
            [['orden_interna_gasto', 'orden_interna_activo', 'tipo_presupuesto'], 'string', 'max' => 20],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProyectoEstadoPedidos::className(), 'targetAttribute' => ['estado_id' => 'id']],
            [['maestra_especial_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaestraEspecial::className(), 'targetAttribute' => ['maestra_especial_id' => 'id']],
            [['proyecto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proyectos::className(), 'targetAttribute' => ['proyecto_id' => 'id']],
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
            'maestra_especial_id' => 'Maestra Especial ID',
            'proyecto_id' => 'Proyecto ID',
            'estado_id' => 'Estado ID',
            'cebe' => 'CeBe',
            'observacion_coordinador' => 'Observacion Coordinador',
            'motivo_rechazo' => 'Motivo Rechazo',
            'orden_interna_gasto' => 'Orden Interna Gasto',
            'orden_interna_activo' => 'Orden Interna Activo',
            'tipo_presupuesto' => 'Tipo Presupuesto',
            'fecha_revision_coordinador' => 'Fecha Revision Coordinador',
            'created_on' => 'Created On',
            'repetido' => 'Repetido',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(ProyectoEstadoPedidos::className(), ['id' => 'estado_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaestraEspecial()
    {
        return $this->hasOne(MaestraEspecial::className(), ['id' => 'maestra_especial_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyecto()
    {
        return $this->hasOne(Proyectos::className(), ['id' => 'proyecto_id']);
    }
}
