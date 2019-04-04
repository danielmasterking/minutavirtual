<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_maestra".
 *
 * @property integer $id
 * @property string $proveedor
 * @property string $material
 * @property string $texto_breve
 * @property string $documento_compras
 * @property string $posicion
 * @property string $organizacion_compras
 * @property string $grupo_de_compras
 * @property string $precio_neto
 * @property string $marca
 * @property string $moneda
 * @property string $unidad_medida
 * @property string $valor_previsto
 * @property string $imputacion
 * @property string $distribucion
 * @property string $indicador_iva
 * @property string $codigo_activo_fijo
 * @property integer $maestra_proveedor_id
 *
 * @property MaestraProveedor $maestraProveedor
 */
class DetalleMaestra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_maestra';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proveedor', 'material', 'texto_breve', 'documento_compras', 'posicion', 'organizacion_compras', 'grupo_de_compras', 'precio_neto', 'valor_previsto', 'maestra_proveedor_id'], 'required'],
             [['fecha_documento', 'fecha_inicio_periodo','fecha_fin_periodo'], 'safe'],
			[['precio_neto', 'valor_previsto','valor_total_maestra','valor_pendiente_por_gastar'], 'number'],
            [['maestra_proveedor_id'], 'integer'],
            [['proveedor', 'documento_compras'], 'string', 'max' => 15],
            [['material', 'marca', 'distribucion'], 'string', 'max' => 45],
            [['texto_breve'], 'string', 'max' => 200],
            [['posicion', 'organizacion_compras'], 'string', 'max' => 5],
            [['grupo_de_compras', 'moneda'], 'string', 'max' => 4],
            [['unidad_medida', 'indicador_iva'], 'string', 'max' => 3],
            [['imputacion'], 'string', 'max' => 10],
            [['codigo_activo_fijo','estado'], 'string', 'max' => 1],
            [['maestra_proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaestraProveedor::className(), 'targetAttribute' => ['maestra_proveedor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fecha_documento' => 'Fecha de documento',
			'fecha_inicio_periodo' => 'Fecha de inicio de maestra',
			'fecha_fin_periodo' => 'Fecha de finalización de maestra',
			'valor_total_maestra' => 'Valor total maestra',
			'valor_pendiente_por_gastar' => 'Valor pendiente por gastar',
			'id' => 'ID',
            'proveedor' => 'Proveedor',
            'material' => 'Material',
            'texto_breve' => 'Texto Breve',
            'documento_compras' => 'Documento Compras',
            'posicion' => 'Posicion',
            'organizacion_compras' => 'Organizacion Compras',
            'grupo_de_compras' => 'Grupo De Compras',
            'precio_neto' => 'Precio Neto',
            'marca' => 'Marca',
            'moneda' => 'Moneda',
            'unidad_medida' => 'Unidad Medida',
            'valor_previsto' => 'Valor Previsto',
            'imputacion' => 'Imputacion',
            'distribucion' => 'Distribucion',
            'indicador_iva' => 'Indicador Iva',
            'codigo_activo_fijo' => 'Codigo Activo Fijo',
            'maestra_proveedor_id' => 'Maestra Proveedor',
			'estado' => 'Estado'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaestra()
    {
        return $this->hasOne(MaestraProveedor::className(), ['id' => 'maestra_proveedor_id']);
    }
}
