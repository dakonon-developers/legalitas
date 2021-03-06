<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Consulta;

/**
 * ActuacionSearch represents the model behind the search form about `app\models\Consulta`.
 */
class ActuacionSearch extends Consulta
{
    public $user;
    public $abogado;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_cliente', 'fk_servicio', 'fk_abogado_asignado', 'finalizado'], 'integer'],
            [['pregunta', 'archivo', 'creado_en', 'fecha_fin','user'], 'safe'],
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
        $query = Consulta::find()->orderBy('creado_en ASC');;

        $query->joinWith('fkCliente');
        $query->joinWith('fkAbogadoAsignado');

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
            'fk_cliente' => $this->fk_cliente,
            'fk_servicio' => $this->fk_servicio,
            'fk_abogado_asignado' => $this->fk_abogado_asignado,
            'finalizado' => $this->finalizado,
            'creado_en' => $this->creado_en,
            'fecha_fin' => $this->fecha_fin,
        ]);

        $query->andFilterWhere(['like', 'pregunta', $this->pregunta])
        ->andFilterWhere(['perfil_usuario.fk_usuario' => $this->user])
        ->andFilterWhere(['perfil_abogado.fk_usuario' => $this->abogado]);

        return $dataProvider;
    }
}