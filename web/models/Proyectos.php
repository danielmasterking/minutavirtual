<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proyectos".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $ceco
 * @property string $solicitante
 * @property string $orden_interna_gasto
 * @property string $orden_interna_activo
 * @property string $presupuesto_total
 * @property string $presupuesto_seguridad
 * @property string $presupuesto_riesgo
 * @property string $presupuesto_heas
 * @property string $suma_total
 * @property string $suma_seguridad
 * @property string $suma_riesgo
 * @property string $suma_heas
 * @property string $fecha_finalizacion
 * @property string $created_on
 * @property string $modificado_por
 * @property string $modified_in
 *
 * @property ProyectoPedidoEspecial[] $proyectoPedidoEspecials
 * @property ProyectoPedidos[] $proyectoPedidos
 * @property CentroCosto $ceco0
 * @property ProyectosPresupuesto[] $proyectosPresupuestos
 */
class Proyectos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proyectos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'ceco', 'solicitante', 'orden_interna_gasto', 'orden_interna_activo', 'presupuesto_total', 'presupuesto_seguridad', 'presupuesto_riesgo', 'presupuesto_heas', 'fecha_finalizacion', 'created_on'], 'required'],
            [['presupuesto_total', 'presupuesto_seguridad', 'presupuesto_riesgo', 'presupuesto_heas', 'suma_total', 'suma_seguridad', 'suma_riesgo', 'suma_heas'], 'number'],
            [['fecha_finalizacion', 'created_on', 'modified_in'], 'safe'],
            [['nombre', 'orden_interna_gasto', 'orden_interna_activo'], 'string', 'max' => 64],
            [['ceco', 'modificado_por'], 'string', 'max' => 15],
            [['solicitante'], 'string', 'max' => 50],
            [['ceco'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['ceco' => 'codigo']],
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
            'ceco' => 'Ceco',
            'solicitante' => 'Solicitante',
            'orden_interna_gasto' => 'Orden Interna Gasto',
            'orden_interna_activo' => 'Orden Interna Activo',
            'presupuesto_total' => 'Presupuesto Total',
            'presupuesto_seguridad' => 'Presupuesto Seguridad',
            'presupuesto_riesgo' => 'Presupuesto Riesgo',
            'presupuesto_heas' => 'Presupuesto Heas',
            'suma_total' => 'Suma Total',
            'suma_seguridad' => 'Suma Seguridad',
            'suma_riesgo' => 'Suma Riesgo',
            'suma_heas' => 'Suma Heas',
            'fecha_finalizacion' => 'Fecha Finalizacion',
            'created_on' => 'Created On',
            'modificado_por' => 'Modificado Por',
            'modified_in' => 'Modified In',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectoPedidoEspecials()
    {
        return $this->hasMany(ProyectoPedidoEspecial::className(), ['proyecto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectoPedidos()
    {
        return $this->hasMany(ProyectoPedidos::className(), ['proyecto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCecoo()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'ceco']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectosPresupuestos()
    {
        return $this->hasMany(ProyectosPresupuesto::className(), ['fk_proyectos' => 'id']);
    }
}
