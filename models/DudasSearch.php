<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dudas;

/**
 * DudasSearch represents the model behind the search form about `app\models\Dudas`.
 */
class DudasSearch extends Dudas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'leido', 'fk_user', 'fk_consulta'], 'integer'],
            [['texto', 'adjunto', 'fecha'], 'safe'],
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
        $query = Dudas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['fecha'=>SORT_ASC]]
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
            'leido' => $this->leido,
            'fecha' => $this->fecha,
            'fk_user' => $this->fk_user,
            'fk_consulta' => $this->fk_consulta,
        ]);

        $query->andFilterWhere(['like', 'texto', $this->texto])
            ->andFilterWhere(['like', 'adjunto', $this->adjunto]);

        return $dataProvider;
    }
}
