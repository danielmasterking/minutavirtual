<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "siniestro".
 *
 * @property integer $id
 * @property string $fecha
 * @property integer $novedad_id
 * @property integer $area_dependencia_id
 * @property integer $zona_dependencia_id
 * @property string $centro_costo_codigo
 * @property string $fotografia
 * @property string $observacion
 * @property string $usuario
 *
 * @property Novedad $novedad
 * @property AreaDependencia $areaDependencia
 * @property ZonaDependencia $zonaDependencia
 * @property CentroCosto $centroCostoCodigo
 * @property Usuario $usuario0
 */
class Siniestro extends \yii\db\ActiveRecord
{
    
	public $name;
    public $image;
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'siniestro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'novedad_id', 'area_dependencia_id', 'zona_dependencia_id', 'centro_costo_codigo', 'usuario'], 'required'],
            [['fecha', 'fecha_siniestro'], 'safe'],
            [['novedad_id', 'area_dependencia_id', 'zona_dependencia_id'], 'integer'],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['fotografia'], 'string', 'max' => 500],
            [['observacion'], 'string', 'max' => 4000],
			[['resumen','recomendaciones'], 'string', 'max' => 2000],
            [['usuario'], 'string', 'max' => 50],
            [['novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Novedad::className(), 'targetAttribute' => ['novedad_id' => 'id']],
            [['area_dependencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => AreaDependencia::className(), 'targetAttribute' => ['area_dependencia_id' => 'id']],
            [['zona_dependencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => ZonaDependencia::className(), 'targetAttribute' => ['zona_dependencia_id' => 'id']],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
			[['image'],'safe'],
            [['image'],'file','extensions'=>'jpg, gif, png, pdf, jpeg', 'maxFiles' => 10],
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
			'fecha_siniestro' => 'Fecha Siniestro',
            'novedad_id' => 'Tipo de siniestro',
            'area_dependencia_id' => 'Area',
            'zona_dependencia_id' => 'Zona',
            'centro_costo_codigo' => 'Dependencia',
            'fotografia' => 'Fotografia',
			'image' => 'Fotografías (10 imágenes máximo)',
            'observacion' => 'Observaciones',
            'usuario' => 'Usuario',
			'resumen' => 'Resumen de los hechos',
			'recomendaciones' => 'Recomendaciones',
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
    public function getAreaDependencia()
    {
        return $this->hasOne(AreaDependencia::className(), ['id' => 'area_dependencia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZonaDependencia()
    {
        return $this->hasOne(ZonaDependencia::className(), ['id' => 'zona_dependencia_id']);
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
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
	
	 public function getFotosSiniestro()
    {
        return $this->hasMany(FotoSiniestro::className(), ['siniestro_id' => 'id']);
    }
}
