<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdminDependencia;

/**
 * AdminDependenciaSearch represents the model behind the search form about `app\models\AdminDependencia`.
 */
class AdminDependenciaSearch extends AdminDependencia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_admin'], 'integer'],
            [['centro_costos_codigo', 'precio'], 'safe'],
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
        $query = AdminDependencia::find();

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
            'id_admin' => $this->id_admin,
        ]);

        $query->andFilterWhere(['like', 'centro_costos_codigo', $this->centro_costos_codigo])
            ->andFilterWhere(['like', 'precio', $this->precio]);

        return $dataProvider;
    }
}
