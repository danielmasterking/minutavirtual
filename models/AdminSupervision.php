<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_supervision".
 *
 * @property integer $id
 * @property string $mes
 * @property string $ano
 * @property string $usuario
 * @property string $created
 * @property string $detalle
 * @property string $precio
 */
class AdminSupervision extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_supervision';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created'], 'safe'],
            [['detalle'], 'string'],
            [['mes'], 'string', 'max' => 2],
            [['ano'], 'string', 'max' => 4],
            [['usuario'], 'string', 'max' => 50],
            [['precio'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mes' => 'Mes',
            'ano' => 'Ano',
            'usuario' => 'Usuario',
            'created' => 'Created',
            'detalle' => 'Detalle',
            'precio' => 'Precio',
        ];
    }
}
