<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HelpRespuestas;

/**
 * HelpRespuestasSearch represents the model behind the search form about `app\models\HelpRespuestas`.
 */
class HelpRespuestasSearch extends HelpRespuestas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_consulta'], 'integer'],
            [['cumple', 'no_cumple', 'en_proceso'], 'safe'],
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
        $query = HelpRespuestas::find();

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
            'id_consulta' => $this->id_consulta,
        ]);

        $query->andFilterWhere(['like', 'cumple', $this->cumple])
            ->andFilterWhere(['like', 'no_cumple', $this->no_cumple])
            ->andFilterWhere(['like', 'en_proceso', $this->en_proceso]);

        return $dataProvider;
    }
}
