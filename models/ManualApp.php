<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "manual_app".
 *
 * @property integer $id
 * @property string $modulo
 * @property string $archivo
 */
class ManualApp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manual_app';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modulo'], 'string', 'max' => 50],
            [['archivo'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'modulo' => 'Modulo',
            'archivo' => 'Archivo',
        ];
    }
}
