<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_invitado".
 *
 * @property integer $id
 * @property string $nombre
 */
class TipoInvitado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_invitado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre','nit_empresa'], 'required'],
            [['nombre'], 'string', 'max' => 20],
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
