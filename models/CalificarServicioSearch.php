<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CalificarServicio;

/**
 * CalificarServicioSearch represents the model behind the search form about `app\models\CalificarServicio`.
 */
class CalificarServicioSearch extends CalificarServicio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ayuda_requerimiento', 'tiempo_respuesta', 'nos_recomendaria', 'fk_consulta'], 'integer'],
            [['ayuda_requerimiento_texto', 'tiempo_respuesta_texto', 'nos_recomendaria_texto'], 'safe'],
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
        $query = CalificarServicio::find();

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
            'ayuda_requerimiento' => $this->ayuda_requerimiento,
            'tiempo_respuesta' => $this->tiempo_respuesta,
            'nos_recomendaria' => $this->nos_recomendaria,
            'fk_consulta' => $this->fk_consulta,
        ]);

        $query->andFilterWhere(['like', 'ayuda_requerimiento_texto', $this->ayuda_requerimiento_texto])
            ->andFilterWhere(['like', 'tiempo_respuesta_texto', $this->tiempo_respuesta_texto])
            ->andFilterWhere(['like', 'nos_recomendaria_texto', $this->nos_recomendaria_texto]);

        return $dataProvider;
    }
}
