<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_servicio".
 *
 * @property integer $id
 * @property integer $servicio_id
 * @property string $codigo
 * @property string $descripcion
 * @property string $precio
 *
 * @property Servicio $servicio
 * @property Puesto[] $puestos
 */
class DetalleServicio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_servicio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['servicio_id', 'codigo', 'descripcion','ano'], 'required'],
            [['servicio_id'], 'integer'],
            [['precio','precio_nocturno'], 'number'],
            [['codigo'], 'string', 'max' => 6],
	[['ano'], 'string', 'max' => 4],
            [['descripcion'], 'string', 'max' => 50],
            [['servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicio::className(), 'targetAttribute' => ['servicio_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'servicio_id' => 'Servicio',
            'codigo' => 'Código',
            'descripcion' => 'Descripcion',
            'precio' => 'Precio Diurno',
            'precio_nocturno' => 'Precio Nocturno',
	        'ano' => 'Año',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicio()
    {
        return $this->hasOne(Servicio::className(), ['id' => 'servicio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuestos()
    {
        return $this->hasMany(Puesto::className(), ['detalle_servicio_id' => 'id']);
    }
}
