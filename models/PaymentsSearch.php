<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payments;

/**
 * PaymentsSearch represents the model behind the search form about `app\models\Payments`.
 */
class PaymentsSearch extends Payments
{
    public $username;
    public $fecha_fin;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_usuario'], 'integer'],
            [['charge_id','fecha','username','fecha_fin','estatus'], 'safe'],
            [['monto'], 'number'],
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
        $query = Payments::find();

        $query->joinWith('fkUsuario');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['fecha'=>SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['username'] = [
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
            'monto' => $this->monto,
            //'fecha' => $this->fecha,
            //'fk_usuario' => $this->fk_usuario,
        ]);

        $query->andFilterWhere(['like', 'charge_id', $this->charge_id])
            ->andFilterWhere(['like', 'estatus', $this->estatus])
            ->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['between','fecha', $inicio , $fin]);

        return $dataProvider;
    }
}
