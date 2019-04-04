<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property string $nit
 * @property string $nombre
 * @property string $logo
 */
class Empresa extends \yii\db\ActiveRecord
{
    public $image;
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nit', 'nombre'], 'required'],
            [['nit'], 'string', 'max' => 10],
            [['nombre'], 'string', 'max' => 45],
            [['logo'], 'string', 'max' => 200],
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
            'nit' => 'Nit',
            'nombre' => 'Nombre',
            'logo' => 'Logo',
			'image' => 'Logo',
        ];
    }
}
