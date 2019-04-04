<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comite".
 *
 * @property integer $id
 * @property integer $novedad_id
 * @property string $usuario
 * @property string $fecha
 * @property string $observaciones
 *
 * @property Novedad $novedad
 * @property Usuario $usuario0
 * @property ComiteDependencia[] $comiteDependencias
 * @property ComiteMarca[] $comiteMarcas
 */
class Comite extends \yii\db\ActiveRecord
{
    
	public $image;
	public $file;
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['novedad_id', 'usuario', 'fecha', 'observaciones'], 'required'],
            [['novedad_id'], 'integer'],
            [['fecha'], 'safe'],
            [['usuario'], 'string', 'max' => 50],
            [['observaciones'], 'string', 'max' => 4000],
			[['foto'], 'string', 'max' => 500],
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
            'novedad_id' => 'Novedad',
            'usuario' => 'Usuario',
            'fecha' => 'Fecha',
            'observaciones' => 'Observaciones',
			'image' => 'Fotografía',
			'file' => 'Acta de asistencia',
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
    public function getUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['usuario' => 'usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDependencias()
    {
        return $this->hasMany(ComiteDependencia::className(), ['comite_id' => 'id']);
    }
	
	 public function getCordinadores()
    {
        return $this->hasMany(ComiteCordinador::className(), ['comite_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarcas()
    {
        return $this->hasMany(ComiteMarca::className(), ['comite_id' => 'id']);
    }
	
	 public function getDistritos()
    {
        return $this->hasMany(ComiteDistrito::className(), ['comite_id' => 'id']);
    }
	
}
