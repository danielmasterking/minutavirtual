<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equivalencia".
 *
 * @property integer $id
 * @property string $elemento
 * @property string $tipo
 * @property string $cuenta
 * @property string $cebe
 * @property string $producto
 * @property string $todo
 */
class Equivalencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equivalencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cuenta'], 'required'],
            [['elemento'], 'string', 'max' => 2],
            [['tipo', 'cebe', 'todo'], 'string', 'max' => 1],
            [['cuenta'], 'string', 'max' => 45],
            [['producto'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'elemento' => 'Elemento',
            'tipo' => 'Tipo',
            'cuenta' => 'Cuenta',
            'cebe' => 'Cebe inicia por',
            'producto' => 'Producto',
            'todo' => 'Todo',
        ];
    }
}
