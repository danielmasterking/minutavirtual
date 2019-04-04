<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visita_mensual".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $fecha_visita
 * @property string $atendio
 * @property string $otro
 * @property string $usuario
 * @property string $centro_costo_codigo
 * @property string $detalle
 * @property string $recomendaciones
 *
 * @property ArchivoVisitaMensual[] $archivoVisitaMensuals
 * @property Usuario $usuario0
 * @property CentroCosto $centroCostoCodigo
 */
class VisitaMensual extends \yii\db\ActiveRecord
{
    
	public $file;
	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visita_mensual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'fecha_visita', 'usuario', 'centro_costo_codigo'], 'required'],
            [['fecha', 'fecha_visita','file'], 'safe'],
            [['atendio', 'otro'], 'string', 'max' => 80],
            [['usuario'], 'string', 'max' => 50],
            [['centro_costo_codigo'], 'string', 'max' => 15],
            [['detalle'], 'string', 'max' => 1000],
            [['recomendaciones'], 'string', 'max' => 1000],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario' => 'usuario']],
            [['centro_costo_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => CentroCosto::className(), 'targetAttribute' => ['centro_costo_codigo' => 'codigo']],
            [['file'],'file','extensions'=>'jpg, gif, png, pdf, jpeg, doc, docx, xls, xlsx, ppt, pptx', 'maxFiles' => 5],
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
            'fecha_visita' => 'Fecha Visita',
            'atendio' => 'Atendio',
            'otro' => 'Otro',
            'usuario' => 'Usuario',
            'centro_costo_codigo' => 'Dependencia',
            'detalle' => 'Observaciones',
			'recomendaciones' => 'Recomendaciones',
			'file' => 'Archivos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchivos()
    {
        return $this->hasMany(ArchivoVisitaMensual::className(), ['visita_mensual_id' => 'id']);
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
    public function getDependencia()
    {
        return $this->hasOne(CentroCosto::className(), ['codigo' => 'centro_costo_codigo']);
    }
}
