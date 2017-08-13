<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "igualas_payments".
 *
 * @property integer $id
 * @property integer $fk_iguala
 * @property integer $fk_servicio_payment
 * @property integer $mes
 *
 * @property Igualas $fkIguala
 * @property ServicioPayments $fkServicioPayment
 */
class IgualasPayments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'igualas_payments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_iguala', 'fk_servicio_payment', 'mes'], 'required'],
            [['fk_iguala', 'fk_servicio_payment', 'mes'], 'integer'],
            [['fk_iguala'], 'exist', 'skipOnError' => true, 'targetClass' => Igualas::className(), 'targetAttribute' => ['fk_iguala' => 'id']],
            [['fk_servicio_payment'], 'exist', 'skipOnError' => true, 'targetClass' => ServicioPayments::className(), 'targetAttribute' => ['fk_servicio_payment' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_iguala' => 'Fk Iguala',
            'fk_servicio_payment' => 'Fk Servicio Payment',
            'mes' => 'Mes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkIguala()
    {
        return $this->hasOne(Igualas::className(), ['id' => 'fk_iguala']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkServicioPayment()
    {
        return $this->hasOne(ServicioPayments::className(), ['id' => 'fk_servicio_payment']);
    }
}
