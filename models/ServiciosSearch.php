<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Servicios;

/**
 * ServiciosSearch represents the model behind the search form about `app\models\Servicios`.
 */
class ServiciosSearch extends Servicios
{
    public $fkMateria;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_materia', 'activo'], 'integer'],
            [['nombre','fkMateria'], 'safe'],
            [['costo'], 'number'],
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
        $query = Servicios::find();

        $query->joinWith('fkMateria');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['fkMateria'] = [
            'asc' => ['materia.nombre' => SORT_ASC],
            'desc' => ['materia.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'fk_materia' => $this->fk_materia,
            'activo' => $this->activo,
            'costo' => $this->costo,
        ]);

        $query->andFilterWhere(['like', 'servicios.nombre', $this->nombre])
            ->andFilterWhere(['like', 'materia.nombre', $this->fkMateria]);

        return $dataProvider;
    }
}
