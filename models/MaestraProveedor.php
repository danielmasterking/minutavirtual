<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maestra_proveedor".
 *
 * @property integer $id
 * @property integer $proveedor_id
 * @property integer $marca_id
 *
 * @property DetalleMaestra[] $detalleMaestras
 * @property Proveedor $proveedor
 * @property Marca $marca
 */
class MaestraProveedor extends \yii\db\ActiveRecord
{
    
	public $file_upload;
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maestra_proveedor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proveedor_id', 'marca_id','zona_id'], 'required'],
			[['estado'], 'string', 'max' => 1],
            [['proveedor_id', 'marca_id','zona_id','zona_id_2','zona_id_3','zona_id_4','zona_id_5','zona_id_6','zona_id_7','zona_id_8','zona_id_9','zona_id_10'], 'integer'],
            [['proveedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedor::className(), 'targetAttribute' => ['proveedor_id' => 'id']],
            [['marca_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marca::className(), 'targetAttribute' => ['marca_id' => 'id']],
			[['zona_id'], 'exist', 'skipOnError' => true, 'targetClass' => Zona::className(), 'targetAttribute' => ['zona_id' => 'id']],
            [['file_upload'],'safe'],
            [['file_upload'],'file','extensions'=>'xls, xlsx'],  
		];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proveedor_id' => 'Proveedor',
            'marca_id' => 'Marca',
			'zona_id' => 'Regional',
			'zona_id_2' => 'Regional 2',
			'zona_id_3' => 'Regional 3',
			'zona_id_4' => 'Regional 4',
			'zona_id_5' => 'Regional 5',
			'zona_id_6' => 'Regional 6',
			'zona_id_7' => 'Regional 7',
			'zona_id_8' => 'Regional 8',
			'zona_id_9' => 'Regional 9',
            'zona_id_10' => 'Regional 10',			
			'file_upload' => 'Archivo de maestra',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleMaestras()
    {
        return $this->hasMany(DetalleMaestra::className(), ['maestra_proveedor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedor()
    {
        return $this->hasOne(Proveedor::className(), ['id' => 'proveedor_id']);
    }
	
	 public function getZona()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id']);
    }
	
	public function getZona2()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id_2']);
    }
	
	public function getZona3()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id_3']);
    }

	public function getZona4()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id_4']);
    }

	public function getZona5()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id_5']);
    }

	public function getZona6()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id_6']);
    }

	public function getZona7()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id_7']);
    }	
	
	public function getZona8()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id_8']);
    }

	public function getZona9()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id_9']);
    }

	public function getZona10()
    {
        return $this->hasOne(Zona::className(), ['id' => 'zona_id_10']);
    }	

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarca()
    {
        return $this->hasOne(Marca::className(), ['id' => 'marca_id']);
    }
}
