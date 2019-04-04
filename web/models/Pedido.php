<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property integer $id
 * @property string $estado
 * @property string $solicitante
 * @property string $centro_costo_codigo
 * @property string $fecha
 * @property string $observaciones
 *
 * @property DetallePedido[] $detallePedidos
 * @property Usuario $solicitante0
 * @property CentroCosto $centroCostoCodigo
 */
class Pedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $file; 
	 
    public static function tableName()
    {
        return 'pedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		
            [['solicitante', 'centro_costo_codigo', 'fecha'], 'required'],
            ['observaciones', 'required', 'message' => 'Por favor, Escriba la Observacion'],
            [['fecha'], 'safe'],
            [['estado','especial'], 'string', 'max' => 1],
            [['solicitante'], 'string', 'max' => 50],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['observaciones'], 'string', 'max' => 200],
            [['solicitante'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['solicitante' => 'usuario']],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
			[['file'],'safe'],
            [['file'],'file','extensions'=>'xlsx, xls, pdf, jpg, gif, png, jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estado' => 'Estado',
            'solicitante' => 'Solicitante',
            'centro_costo_codigo' => 'Dependencia',
            'fecha' => 'Fecha',
            'observaciones' => 'Observaciones',
			'especial' => 'especial',
			'file' => 'Cotización',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetallePedidos()
    {
        return $this->hasMany(DetallePedido::className(), ['pedido_id' => 'id']);
    }
	
	 public function getDetallePedidosEspecial()
    {
        return $this->hasMany(DetallePedidoEspecial::className(), ['pedido_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitante()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'solicitante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
