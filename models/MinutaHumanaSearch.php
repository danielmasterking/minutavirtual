<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MinutaHumana;

/**
 * MinutaHumanaSearch represents the model behind the search form about `app\models\MinutaHumana`.
 */
class MinutaHumanaSearch extends MinutaHumana
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cedula_persona', 'tipo_observacion', 'tipo_invitado'], 'integer'],
            [['hora_entrada', 'hora_salida', 'fecha'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MinutaHumana::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cedula_persona' => $this->cedula_persona,
            'hora_entrada' => $this->hora_entrada,
            'hora_salida' => $this->hora_salida,
            'fecha' => $this->fecha,
            'tipo_observacion' => $this->tipo_observacion,
            'tipo_invitado' => $this->tipo_invitado,
        ]);

        return $dataProvider;
    }
}
