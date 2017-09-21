<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Calificacion;

/**
 * CalificacionSearch represents the model behind the search form about `app\models\Calificacion`.
 */
class CalificacionSearch extends Calificacion
{
    public $abogado;
    public $abogado_documento;
    public $cliente_documento;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_consulta'], 'integer'],
            [['calificacion'], 'number'],
            [['abogado','abogado_documento','cliente_documento'], 'safe'],
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
        $query = Calificacion::find();

        $query->joinWith('fkConsulta');
        $query->joinWith('fkConsulta.fkAbogadoAsignado');
        $query->joinWith('fkConsulta.fkCliente');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['abogado_documento'] = [
            'asc' => ['perfil_abogado.documento_identidad' => SORT_ASC],
            'desc' => ['perfil_abogado.documento_identidad' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['cliente_documento'] = [
            'asc' => ['perfil_usuario.documento_identidad' => SORT_ASC],
            'desc' => ['perfil_usuario.documento_identidad' => SORT_DESC],
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
            'fk_consulta' => $this->fk_consulta,
            'calificacion' => $this->calificacion,
            'consulta.fk_abogado_asignado' => $this->abogado,
        ]);

        //$query->andFilterWhere(['like', 'nombres', $this->user]);
        $query->andFilterWhere(['like', 'perfil_abogado.documento_identidad', $this->abogado_documento])
            ->andFilterWhere(['like', 'perfil_usuario.documento_identidad', $this->cliente_documento]);


        return $dataProvider;
    }
}
