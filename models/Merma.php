<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "merma".
 *
 * @property integer $id
 * @property string $fecha
 * @property integer $area_dependencia_id
 * @property integer $zona_dependencia_id
 * @property string $usuario
 * @property string $recomendaciones
 * @property integer $cantidad
 * @property string $valor
 * @property string $total
 */
class Merma extends \yii\db\ActiveRecord
{
    public $name;
    public $image;
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'area_dependencia_id', 'zona_dependencia_id', 'usuario'], 'required'],
            [['fecha'], 'safe'],
            [['area_dependencia_id', 'zona_dependencia_id', 'cantidad'], 'integer'],
            [['valor', 'total'], 'number'],
            [['usuario'], 'string', 'max' => 50],
			[['material'], 'string', 'max' => 400],
            [['recomendaciones'], 'string', 'max' => 2000],
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
            'area_dependencia_id' => 'Area',
            'zona_dependencia_id' => 'Zona',
            'usuario' => 'Usuario',
            'recomendaciones' => 'Recomendaciones',
            'cantidad' => 'Cantidad',
            'valor' => 'Valor unitario',
		    'image' => 'Fotografías (10 imágenes máximo)',
            'total' => 'Total Recuperado',
			'material' => 'Material'
			
        ];
    }
	
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

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }
	
    public function getMermaDependencias()
    {
        return $this->hasMany(MermaDependencia::className(), ['merma_id' => 'id']);
    }
	
	 public function getFotosMerma()
    {
        return $this->hasMany(FotoMerma::className(), ['merma_id' => 'id']);
    }	
}
