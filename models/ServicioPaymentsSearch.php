<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ServicioPayments;

/**
 * ServicioPaymentsSearch represents the model behind the search form about `app\models\ServicioPayments`.
 */
class ServicioPaymentsSearch extends ServicioPayments
{
    public $fecha;
    public $fecha_fin;
    public $servicio;
    public $cliente;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_service', 'fk_users_cliente', 'fk_payments'], 'integer'],
            [['fecha','fecha_fin','servicio','cliente'],'safe']
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
        $query = ServicioPayments::find();

        $query->joinWith('fkPayments');
        $query->joinWith('fkService');
        $query->joinWith('fkUsersCliente.fkUsuario');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['servicio'] = [
            'asc' => ['servicios.nombre' => SORT_ASC],
            'desc' => ['servicios.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['cliente'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

                // Filtro por fechas
        $inicio = '';
        $fin = '';

        if($this->fecha!=''){
            $formato = \DateTime::createFromFormat('d/m/Y', $this->fecha);
            if($formato){
                $inicio = strtotime($formato->format('Y-m-d 00:00:00'));
                if($this->fecha_fin!=''){
                    $formato = \DateTime::createFromFormat('d/m/Y', $this->fecha_fin);
                    if($formato){
                        $fin = strtotime($formato->format('Y-m-d 00:00:00 +1'));
                    }
                }
                else{
                    $fin = strtotime(date('Y-m-d H:i:s'));    
                }
            }
            
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fk_service' => $this->fk_service,
            'fk_users_cliente' => $this->fk_users_cliente,
            'fk_payments' => $this->fk_payments,
        ]);

        $query->andFilterWhere(['between','payments.fecha', $inicio , $fin])
            ->andFilterWhere(['like', 'user.username', $this->cliente])
            ->andFilterWhere(['like', 'servicios.nombre', $this->servicio]);

        return $dataProvider;
    }
}
