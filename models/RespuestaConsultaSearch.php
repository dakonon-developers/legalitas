<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RespuestaConsulta;

/**
 * RespuestaConsultaSearch represents the model behind the search form about `app\models\RespuestaConsulta`.
 */
class RespuestaConsultaSearch extends RespuestaConsulta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_abogado', 'fk_consulta'], 'integer'],
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
        $query = RespuestaConsulta::find();

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
            'fecha' => $this->fecha,
            'fk_abogado' => $this->fk_abogado,
            'fk_consulta' => $this->fk_consulta,
        ]);

        $query->andFilterWhere(['like', 'texto', $this->texto])
            ->andFilterWhere(['like', 'adjunto', $this->adjunto]);

        return $dataProvider;
    }
}
