<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PerfilUsuario;

/**
 * PerfilUsuarioSearch represents the model behind the search form about `app\models\PerfilUsuario`.
 */
class PerfilUsuarioSearch extends PerfilUsuario
{
    public $username;
    public $email;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activo', 'fk_nacionalidad', 'fk_municipio', 'fk_usuario'], 'integer'],
            [['nombres', 'apellidos', 'documento_identidad', 'foto_documento_identidad', 
            'telefono_oficina', 'celular', 'tarjeta_credito', 'categoria',
            'username','email'], 'safe'],
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
        $query = PerfilUsuario::find();

        $query->joinWith('fkUsuario');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['email'] = [
            'asc' => ['email' => SORT_ASC],
            'desc' => ['email' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['username'] = [
            'asc' => ['username' => SORT_ASC],
            'desc' => ['username' => SORT_DESC],
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
            'activo' => $this->activo,
            'fk_nacionalidad' => $this->fk_nacionalidad,
            'fk_municipio' => $this->fk_municipio,
            'fk_usuario' => $this->fk_usuario,
        ]);

        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'documento_identidad', $this->documento_identidad])
            ->andFilterWhere(['like', 'foto_documento_identidad', $this->foto_documento_identidad])
            ->andFilterWhere(['like', 'telefono_oficina', $this->telefono_oficina])
            ->andFilterWhere(['like', 'celular', $this->celular])
            ->andFilterWhere(['like', 'tarjeta_credito', $this->tarjeta_credito])
            ->andFilterWhere(['like', 'categoria', $this->categoria])
            ->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'user.username', $this->username])
            ;

        return $dataProvider;
    }
}
