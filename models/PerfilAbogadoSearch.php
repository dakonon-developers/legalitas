<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PerfilAbogado;

/**
 * PerfilAbogadoSearch represents the model behind the search form about `app\models\PerfilAbogado`.
 */
class PerfilAbogadoSearch extends PerfilAbogado
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tipo_abogado', 'activo', 'fk_nacionalidad', 'fk_municipio', 'fk_usuario'], 'integer'],
            [['nombres', 'apellidos', 'documento_identidad', 'foto_documento_identidad', 'exequatur', 'num_carnet', 'telefono_oficina', 'celular', 'cv_adjunto'], 'safe'],
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
        $query = PerfilAbogado::find();

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
            'tipo_abogado' => $this->tipo_abogado,
            'activo' => $this->activo,
            'fk_nacionalidad' => $this->fk_nacionalidad,
            'fk_municipio' => $this->fk_municipio,
            'fk_usuario' => $this->fk_usuario,
        ]);

        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'documento_identidad', $this->documento_identidad])
            ->andFilterWhere(['like', 'foto_documento_identidad', $this->foto_documento_identidad])
            ->andFilterWhere(['like', 'exequatur', $this->exequatur])
            ->andFilterWhere(['like', 'num_carnet', $this->num_carnet])
            ->andFilterWhere(['like', 'telefono_oficina', $this->telefono_oficina])
            ->andFilterWhere(['like', 'celular', $this->celular])
            ->andFilterWhere(['like', 'cv_adjunto', $this->cv_adjunto]);

        return $dataProvider;
    }
}
