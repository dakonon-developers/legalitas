<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Preguntas;

/**
 * PreguntasSearch represents the model behind the search form about `app\models\Preguntas`.
 */
class PreguntasSearch extends Preguntas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'demandado', 'cantidad', 'consulta_info', 'fk_user'], 'integer'],
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
        $query = Preguntas::find();

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
            'demandado' => $this->demandado,
            'cantidad' => $this->cantidad,
            'consulta_info' => $this->consulta_info,
            'fk_user' => $this->fk_user,
        ]);

        return $dataProvider;
    }
}
