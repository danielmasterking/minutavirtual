<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PreciosMonitoreo;

/**
 * PreciosMonitoreoSearch represents the model behind the search form about `app\models\PreciosMonitoreo`.
 */
class PreciosMonitoreoSearch extends PreciosMonitoreo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_empresa', 'id_sistema_monitoreo'], 'integer'],
            [['valor_unitario', 'ano'], 'safe'],
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
        $query = PreciosMonitoreo::find();

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
            'id_empresa' => $this->id_empresa,
            'id_sistema_monitoreo' => $this->id_sistema_monitoreo,
            'ano' => $this->ano,
        ]);

        $query->andFilterWhere(['like', 'valor_unitario', $this->valor_unitario]);

        return $dataProvider;
    }
}
