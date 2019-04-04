<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "incidente".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $detalle
 * @property string $recomendaciones
 * @property string $usuario
 * @property string $centro_costo_codigo
 * @property integer $novedad_id
 */
class Incidente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $name;
    public $image;
	public $image2;//imagen que acompaña el detalle.
    
	public static function tableName()
    {
        return 'incidente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'usuario', 'centro_costo_codigo', 'novedad_id'], 'required'],
            [['fecha'], 'safe'],
            [['novedad_id'], 'integer'],
            [['detalle'], 'string', 'max' => 2500],
            [['recomendaciones'], 'string', 'max' => 1500],
            [['usuario'], 'string', 'max' => 50],
            [['centro_costo_codigo'], 'string', 'max' => 15],
			[['image'],'safe'],
			[['image2'],'safe'],
			[['image2'],'file','extensions'=>'jpg, gif, png, pdf, jpeg', 'maxFiles' => 1],
            [['image'],'file','extensions'=>'jpg, gif, png, pdf, jpeg, pdf, docx, xlsx', 'maxFiles' => 10],
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
            'detalle' => 'Detalle',
            'recomendaciones' => 'Recomendaciones',
            'usuario' => 'Usuario',
			'image' => 'Investigaciones previas',
			'image2' => 'Fotografía',
            'centro_costo_codigo' => 'Dependencia',
            'novedad_id' => 'Tipo de incidente',
        ];
    }
	
	 public function getNovedad()
    {
        return $this->hasOne(Novedad::className(), ['id' => 'novedad_id']);
    }
	
	 public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
	
	 public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
	
	 public function getFotosIncidente()
    {
        return $this->hasMany(FotoIncidente::className(), ['incidente_id' => 'id']);
    }
}
