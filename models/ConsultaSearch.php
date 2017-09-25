<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Consulta;

/**
 * ConsultaSearch represents the model behind the search form about `app\models\Consulta`.
 */
class ConsultaSearch extends Consulta
{
    public $servicio;
    public $abogado_asignado;
    public $cliente;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_cliente', 'fk_servicio', 'fk_abogado_asignado', 'finalizado'], 'integer'],
            [['pregunta', 'archivo', 'creado_en', 'fecha_fin','servicio','abogado_asignado','cliente'], 'safe'],
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
        $query = Consulta::find();

        //Joins de la tabla
        $query->joinWith('fkServicio');
        $query->joinWith('fkAbogadoAsignado');
        $query->joinWith('fkCliente');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['creado_en'=>SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['servicio'] = [
            'asc' => ['servicios.nombre' => SORT_ASC],
            'desc' => ['servicios.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['abogado_asignado'] = [
            'asc' => ['perfil_abogado.nombres' => SORT_ASC],
            'desc' => ['perfil_abogado.nombres' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['cliente'] = [
            'asc' => ['perfil_usuario.nombres' => SORT_ASC],
            'desc' => ['perfil_usuario.nombres' => SORT_DESC],
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
            'fk_cliente' => $this->fk_cliente,
            'fk_servicio' => $this->fk_servicio,
            'fk_abogado_asignado' => $this->fk_abogado_asignado,
            'finalizado' => $this->finalizado,
            //'creado_en' => $this->creado_en,
            //'fecha_fin' => $this->fecha_fin,
        ]);

        $inicio = '';
        $fin = '';
        if($this->creado_en!=''){
            $formato = \DateTime::createFromFormat('d/m/Y', $this->creado_en);
            if($formato){
                $inicio = strtotime($formato->format('Y-m-d 00:00:00'));
                if($this->fecha_fin!=''){
                    $formato = \DateTime::createFromFormat('d/m/Y', $this->fecha_fin);
                    if($formato){
                        $fin = $formato->format('Y-m-d');
                    }
                }
            }
            
        }

        $query->andFilterWhere(['like', 'pregunta', $this->pregunta])
            ->andFilterWhere(['like', 'archivo', $this->archivo])
            ->andFilterWhere([
                'or',
                ['like', 'perfil_usuario.nombres', $this->cliente],
                ['like', 'perfil_usuario.apellidos', $this->cliente],
            ])
            ->andFilterWhere([
                'or',
                ['like', 'perfil_abogado.nombres', $this->abogado_asignado],
                ['like', 'perfil_abogado.apellidos', $this->abogado_asignado],
            ])
            ->andFilterWhere(['like', 'servicios.nombre', $this->servicio])
            ->andFilterWhere(['>=', 'creado_en', $inicio])
            ->andFilterWhere(['fecha_fin' => $fin])
            ;

        return $dataProvider;
    }
}
