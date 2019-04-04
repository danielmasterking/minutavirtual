<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proyecto_pedidos".
 *
 * @property integer $id
 * @property integer $detalle_maestra_id
 * @property integer $proyecto_id
 * @property integer $estado_id
 * @property integer $cantidad
 * @property double $precio_neto
 * @property string $observaciones
 * @property string $observacion_coordinador
 * @property string $motivo_rechazo
 * @property string $cebe
 * @property string $orden_interna_gasto
 * @property string $orden_interna_activo
 * @property string $tipo_presupuesto
 * @property string $fecha_revision_coordinador
 * @property string $created_on
 * @property string $repetido
 *
 * @property ProyectoEstadoPedidos $estado
 * @property DetalleMaestra $detalleMaestra
 * @property Proyectos $proyecto
 */
class ProyectoPedidos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proyecto_pedidos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detalle_maestra_id', 'proyecto_id', 'estado_id', 'created_on'], 'required'],
            [['detalle_maestra_id', 'proyecto_id', 'estado_id', 'cantidad'], 'integer'],
            [['precio_neto'], 'number'],
            [['fecha_revision_coordinador', 'created_on'], 'safe'],
            [['repetido'], 'string'],
            [['observaciones', 'motivo_rechazo'], 'string', 'max' => 200],
            [['observacion_coordinador'], 'string', 'max' => 100],
            [['cebe'], 'string', 'max' => 10],
            [['orden_interna_gasto', 'orden_interna_activo', 'tipo_presupuesto'], 'string', 'max' => 20],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProyectoEstadoPedidos::className(), 'targetAttribute' => ['estado_id' => 'id']],
            [['detalle_maestra_id'], 'exist', 'skipOnError' => true, 'targetClass' => DetalleMaestra::className(), 'targetAttribute' => ['detalle_maestra_id' => 'id']],
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
            'detalle_maestra_id' => 'Detalle Maestra ID',
            'proyecto_id' => 'Proyecto ID',
            'estado_id' => 'Estado ID',
            'cantidad' => 'Cantidad',
            'precio_neto' => 'Precio Neto',
            'observaciones' => 'Observaciones',
            'observacion_coordinador' => 'Observacion Coordinador',
            'motivo_rechazo' => 'Motivo Rechazo',
            'cebe' => 'Cebe',
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
    public function getDetalleMaestra()
    {
        return $this->hasOne(DetalleMaestra::className(), ['id' => 'detalle_maestra_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyecto()
    {
        return $this->hasOne(Proyectos::className(), ['id' => 'proyecto_id']);
    }
}
