<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prefactura_dispositivo_fijo_electronico".
 *
 * @property integer $id
 * @property string $estado
 * @property string $sistema
 * @property integer $id_tipo_alarma
 * @property integer $id_marca
 * @property string $referencia
 * @property integer $ubicacion
 * @property string $zona_panel
 * @property integer $meses_pactados
 * @property string $fecha_inicio
 * @property string $fecha_ultima_reposicion
 * @property string $valor_arrendamiento_mensual
 * @property string $centro_costos_codigo
 * @property integer $id_desc
 * @property integer $id_prefactura_electronica
 */
class PrefacturaDispositivoFijoElectronico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prefactura_dispositivo_fijo_electronico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo_alarma', 'id_marca', 'ubicacion', 'meses_pactados', 'id_desc', 'id_prefactura_electronica'], 'integer'],
            [['referencia'], 'string'],
            [['fecha_inicio', 'fecha_ultima_reposicion'], 'safe'],
            [['estado', 'sistema'], 'string', 'max' => 30],
            [['zona_panel'], 'string', 'max' => 50],
            [['valor_arrendamiento_mensual', 'centro_costos_codigo'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estado' => 'Estado',
            'sistema' => 'Sistema',
            'id_tipo_alarma' => 'Id Tipo Alarma',
            'id_marca' => 'Id Marca',
            'referencia' => 'Referencia',
            'ubicacion' => 'Ubicacion',
            'zona_panel' => 'Zona Panel',
            'meses_pactados' => 'Meses Pactados',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_ultima_reposicion' => 'Fecha Ultima Reposicion',
            'valor_arrendamiento_mensual' => 'Valor Arrendamiento Mensual',
            'centro_costos_codigo' => 'Centro Costos Codigo',
            'id_desc' => 'Id Desc',
            'id_prefactura_electronica' => 'Id Prefactura Electronica',
        ];
    }


    public function getIdPrefacturaelectronica()
    {
        return $this->hasOne(PrefacturaFija::className(), ['id' => 'id_prefactura_electronica']);
    }


    public function getTipoalarma()
    {
        return $this->hasOne(TipoAlarma::className(), ['id' => 'id_tipo_alarma']);
    }

    public function getMarcaalarma()
    {
        return $this->hasOne(MarcaAlarma::className(), ['id' => 'id_marca']);
    }


    public function getAreas()
    {
        return $this->hasOne(AreaDependencia::className(), ['id' => 'ubicacion']);
    }


    public function getDesc()
    {
        return $this->hasOne(DescAlarma::className(), ['id' => 'id_desc']);
    }



    public function number_unformat($number, $force_number = true, $dec_point = ',', $thousands_sep = '.') {
        if ($force_number) {
            $number = preg_replace('/^[^\d]+/', '', $number);
        } else if (preg_match('/^[^\d]+/', $number)) {
            return false;
        }
        $type = (strpos($number, $dec_point) === false) ? 'int' : 'float';
        $number = str_replace(array($dec_point, $thousands_sep), array('.', ''), $number);
        settype($number, $type);
        return $number;
    }

}
