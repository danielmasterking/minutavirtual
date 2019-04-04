<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_observacion".
 *
 * @property integer $id
 * @property string $nombre
 */
class TipoObservacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_observacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre','nit_empresa'], 'required'],
            [['nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['nit' => 'nit_empresa']);
    }
}
