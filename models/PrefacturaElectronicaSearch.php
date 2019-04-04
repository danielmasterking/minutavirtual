<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PrefacturaElectronica;

/**
 * PrefacturaElectronicaSearch represents the model behind the search form about `app\models\PrefacturaElectronica`.
 */
class PrefacturaElectronicaSearch extends PrefacturaElectronica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['mes', 'ano', 'usuario', 'centro_costo_codigo', 'empresa', 'created', 'updated', 'regional', 'ciudad', 'marca', 'estado'], 'safe'],
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
        $query = PrefacturaElectronica::find();

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
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'mes', $this->mes])
            ->andFilterWhere(['like', 'ano', $this->ano])
            ->andFilterWhere(['like', 'usuario', $this->usuario])
            ->andFilterWhere(['like', 'centro_costo_codigo', $this->centro_costo_codigo])
            ->andFilterWhere(['like', 'empresa', $this->empresa])
            ->andFilterWhere(['like', 'regional', $this->regional])
            ->andFilterWhere(['like', 'ciudad', $this->ciudad])
            ->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
