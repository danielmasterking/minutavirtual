<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evento".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $centro_costo_codigo
 * @property string $otros
 * @property string $cantidad_apoyo
 * @property string $descripcion
 * @property string $usuario
 * @property integer $novedad_id
 *
 * @property CentroCosto $centroCostoCodigo
 * @property Usuario $usuario0
 * @property Novedad $novedad
 * @property EventoDistrito[] $eventoDistritos
 * @property EventoMarca[] $eventoMarcas
 * @property FotoEvento[] $fotoEventos
 */
class Evento extends \yii\db\ActiveRecord
{
        public $image;
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'usuario', 'novedad_id'], 'required'],
            [['fecha'], 'safe'],
            [['novedad_id'], 'integer'],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['otros'], 'string', 'max' => 150],
            [['cantidad_apoyo','cantidad_apoyo_otros'], 'string', 'max' => 45],
            [['descripcion'], 'string', 'max' => 3000],
            [['usuario'], 'string', 'max' => 50],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
            [['novedad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Novedad::className(), 'targetAttribute' => ['novedad_id' => 'id']],
        	[['image'],'safe'],
            [['image'],'file','extensions'=>'jpg, gif, png, pdf, jpeg', 'maxFiles' => 3],
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
            'otros' => '',
            'cantidad_apoyo' => 'Cantidad de Apoyo',
			'cantidad_apoyo_otros' => '',
            'descripcion' => 'Descripción',
            'usuario' => 'Usuario',
            'novedad_id' => 'Tipo de solicitud',
			'image' => 'Fotografías (3 imágenes máximo)',
        ];
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
    public function getEventoDistritos()
    {
        return $this->hasMany(EventoDistrito::className(), ['evento_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventoMarcas()
    {
        return $this->hasMany(EventoMarca::className(), ['evento_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFotoEventos()
    {
        return $this->hasMany(FotoEvento::className(), ['evento_id' => 'id']);
    }
}
