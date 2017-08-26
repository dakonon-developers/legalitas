<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property integer $id
 * @property string $charge_id
 * @property double $monto
 * @property integer $fecha
 *
 * @property ServicioPayments[] $servicioPayments
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['charge_id', 'monto', 'fecha'], 'required'],
            [['monto'], 'number'],
            [['fecha'], 'integer'],
            [['charge_id'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'charge_id' => 'Charge ID',
            'monto' => 'Monto',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicioPayments()
    {
        return $this->hasMany(ServicioPayments::className(), ['fk_payments' => 'id']);
    }
}
