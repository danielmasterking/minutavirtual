<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "centro_costo".
 *
 * @property string $codigo
 * @property string $nombre
 * @property string $direccion
 * @property string $ciudad_codigo_dane
 * @property integer $marca_id
 *
 * @property Analisis[] $analises
 * @property CapacitacionDependencia[] $capacitacionDependencias
 * @property Ciudad $ciudadCodigoDane
 * @property Marca $marca
 * @property CentroDistrito[] $centroDistritos
 * @property Consigna[] $consignas
 * @property Responsable[] $responsables
 * @property Siniestro[] $siniestros
 * @property UsuarioDependencia[] $usuarioDependencias
 * @property VisitaDia[] $visitaDias
 */
class CentroCosto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 public $image;
	 
    public static function tableName()
    {
        return 'centro_costo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'nombre', 'direccion', 'ciudad_codigo_dane', 'marca_id'], 'required'],
            [['marca_id'], 'integer'],
            [['codigo','cebe'], 'string', 'max' => 15],
            [['nombre', 'direccion'], 'string', 'max' => 150],
            [['ciudad_codigo_dane'], 'string', 'max' => 8],
			[['telefono'], 'string', 'max' => 25],
			[['ceco','empresa'], 'string', 'max' => 10],
			[['estado'], 'string', 'max' => 1],
			[['foto'], 'string', 'max' => 500],
            [['ciudad_codigo_dane'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudad::className(), 'targetAttribute' => ['ciudad_codigo_dane' => 'codigo_dane']],
            [['marca_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marca::className(), 'targetAttribute' => ['marca_id' => 'id']],
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
            
			'codigo' => 'Codigo',
            'nombre' => 'Nombre',
            'direccion' => 'Direccion',
            'ciudad_codigo_dane' => 'Ciudad Codigo Dane',
            'marca_id' => 'Marca',
			'image' => 'Fotografía',
			'foto' => 'Fotografía',
			'telefono' => 'Teléfono',
			'estado' => 'Estado',
			'cebe' => 'CeBe',
			'ceco' => 'CeCo',
			'empresa' => 'Empresa',
			
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalises()
    {
        return $this->hasMany(Analisis::className(), ['centro_costo_codigo' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCapacitacionDependencias()
    {
        return $this->hasMany(CapacitacionDependencia::className(), ['centro_costo_codigo' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudad()
    {
        return $this->hasOne(Ciudad::className(), ['codigo_dane' => 'ciudad_codigo_dane']);
    }
	
	 public function getEmp()
    {
        return $this->hasOne(Empresa::className(), ['nit' => 'empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarca()
    {
        return $this->hasOne(Marca::className(), ['id' => 'marca_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependenciasDistrito()
    {
        return $this->hasMany(CentroDistrito::className(), ['centro_costo_codigo' => 'codigo']);
    }
	
	 public function getAuditoriaPresupuesto()
    {
        return $this->hasMany(AuditoriaPresupuesto::className(), ['centro_costo_codigo' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsignas()
    {
        return $this->hasMany(Consigna::className(), ['centro_costo_codigo' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsables()
    {
        return $this->hasMany(Responsable::className(), ['centro_costo_codigo' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiniestros()
    {
        return $this->hasMany(Siniestro::className(), ['centro_costo_codigo' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioDependencias()
    {
        return $this->hasMany(UsuarioDependencia::className(), ['centro_costo_codigo' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitaDias()
    {
        return $this->hasMany(VisitaDia::className(), ['centro_costo_codigo' => 'codigo']);
    }
}
