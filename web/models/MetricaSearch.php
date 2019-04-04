<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Metrica;

/**
 * MetricaSearch represents the model behind the search form about `app\models\Metrica`.
 */
class MetricaSearch extends Metrica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'peso', 'meta', 'periodicidad_id', 'indicador_id'], 'integer'],
            [['nombre', 'detalle'], 'safe'],
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
        $query = Metrica::find();

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
            'peso' => $this->peso,
            'meta' => $this->meta,
            'periodicidad_id' => $this->periodicidad_id,
            'indicador_id' => $this->indicador_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'detalle', $this->detalle]);

        return $dataProvider;
    }
}
