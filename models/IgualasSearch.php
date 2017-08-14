<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Igualas;

/**
 * IgualasSearch represents the model behind the search form about `app\models\Igualas`.
 */
class IgualasSearch extends Igualas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'slim_duracion', 'med_duracion', 'plus_duracion'], 'integer'],
            [['nombre', 'descripcion'], 'safe'],
            [['slim', 'med', 'plus', 'slim_stripe', 'med_stripe', 'plus_stripe'], 'number'],
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
        $query = Igualas::find();

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
            'slim_duracion' => $this->slim_duracion,
            'med_duracion' => $this->med_duracion,
            'plus_duracion' => $this->plus_duracion,
            'slim' => $this->slim,
            'med' => $this->med,
            'plus' => $this->plus,
            'slim_stripe' => $this->slim_stripe,
            'med_stripe' => $this->med_stripe,
            'plus_stripe' => $this->plus_stripe,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
