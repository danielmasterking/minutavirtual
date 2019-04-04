<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "capacitacion".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $hora_inicio
 * @property string $duracion
 * @property string $foto
 * @property string $lista
 * @property integer $novedad_id
 * @property string $observaciones
 * @property string $usuario
 *
 * @property Novedad $novedad
 * @property Usuario $usuario0
 * @property CapacitacionDependencia[] $capacitacionDependencias
 */
class Capacitacion extends \yii\db\ActiveRecord
{
    public $name;
    public $image;
	public $file;
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'capacitacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'novedad_id', 'usuario', 'fecha_capacitacion'], 'required'],
            [['fecha', 'fecha_capacitacion'], 'safe'],
            [['novedad_id'], 'integer'],
            [['foto', 'lista'], 'string', 'max' => 500],
            [['observaciones'], 'string', 'max' => 5000],
            [['usuario'], 'string', 'max' => 50],
            [['novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Novedad::className(), 'targetAttribute' => ['novedad_id' => 'id']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
			[['image'],'safe'],
            [['image'],'file','extensions'=>'jpg, gif, png, jpeg'],
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
            'fecha' => 'Fecha',
			'fecha_capacitacion' => 'Fecha Capacitación',
            'foto' => 'Fotografía',
			'image' => 'Registro Fotografico',
			'file' => 'Acta de asistencia',
            'lista' => 'Acta de asistencia',
            'novedad_id' => 'Tema',
            'observaciones' => 'Observaciones',
            'usuario' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNovedad()
    {
        return $this->hasOne(Novedad::className(), ['id' => 'novedad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCapacitacionDependencias()
    {
        return $this->hasMany(CapacitacionDependencia::className(), ['capacitacion_id' => 'id']);
    }
	
	 public function getCapacitacionInstructor()
    {
        return $this->hasMany(CapacitacionInstructor::className(), ['capacitacion_id' => 'id']);
    }
}
