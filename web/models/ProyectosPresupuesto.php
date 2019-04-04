<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proyectos_presupuesto".
 *
 * @property integer $id
 * @property integer $fk_proyectos
 * @property string $presupuesto_seguridad
 * @property string $presupuesto_riesgo
 * @property string $presupuesto_heas
 * @property string $created_on
 *
 * @property Proyectos $fkProyectos
 */
class ProyectosPresupuesto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proyectos_presupuesto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_proyectos', 'presupuesto_seguridad', 'presupuesto_riesgo', 'presupuesto_heas', 'created_on'], 'required'],
            [['fk_proyectos'], 'integer'],
            [['presupuesto_seguridad', 'presupuesto_riesgo', 'presupuesto_heas'], 'number'],
            [['created_on'], 'safe'],
            [['fk_proyectos'], 'exist', 'skipOnError' => true, 'targetClass' => Proyectos::className(), 'targetAttribute' => ['fk_proyectos' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_proyectos' => 'Fk Proyectos',
            'presupuesto_seguridad' => 'Presupuesto Seguridad',
            'presupuesto_riesgo' => 'Presupuesto Riesgo',
            'presupuesto_heas' => 'Presupuesto Heas',
            'created_on' => 'Created On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkProyectos()
    {
        return $this->hasOne(Proyectos::className(), ['id' => 'fk_proyectos']);
    }
}
