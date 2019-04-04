<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visita_dia".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $centro_costo_codigo
 * @property string $usuario
 * @property string $observaciones
 * @property string $responsable
 * @property string $otro
 *
 * @property DetalleVisitaDia[] $detalleVisitaDias
 * @property CentroCosto $centroCostoCodigo
 * @property Usuario $usuario0
 */
class VisitaDia extends \yii\db\ActiveRecord
{
    
	public $image;
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visita_dia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'centro_costo_codigo', 'usuario'], 'required'],
            [['fecha'], 'safe'],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['usuario'], 'string', 'max' => 50],
			[['foto'], 'string', 'max' => 500],
            [['observaciones'], 'string', 'max' => 4000],
            [['responsable', 'otro'], 'string', 'max' => 80],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
            [['image'],'safe'],
            [['image'],'file','extensions'=>'jpg, gif, png, jpeg'],        
		];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'centro_costo_codigo' => 'Dependencia',
            'usuario' => 'Usuario',
            'observaciones' => 'Observaciones',
            'responsable' => 'Atendió visita',
            'otro' => 'Otro',
			'image' => 'Fotografía',
			'foto' => 'Fotografía',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalle()
    {
        return $this->hasMany(DetalleVisitaDia::className(), ['visita_dia_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
}
