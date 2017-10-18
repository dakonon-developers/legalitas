<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicio_payments".
 *
 * @property integer $id
 * @property integer $fk_service
 * @property integer $fk_users_cliente
 * @property integer $fk_payments
 *
 * @property IgualasPayments[] $igualasPayments
 * @property Payments $fkPayments
 * @property PerfilUsuario $fkUsersCliente
 * @property Servicios $fkService
 */
class ServicioPayments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'servicio_payments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_service', 'fk_users_cliente', 'fk_payments'], 'required'],
            [['fk_service', 'fk_users_cliente', 'fk_payments'], 'integer'],
            [['fk_payments'], 'exist', 'skipOnError' => true, 'targetClass' => Payments::className(), 'targetAttribute' => ['fk_payments' => 'id']],
            [['fk_users_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilUsuario::className(), 'targetAttribute' => ['fk_users_cliente' => 'id']],
            [['fk_service'], 'exist', 'skipOnError' => true, 'targetClass' => Servicios::className(), 'targetAttribute' => ['fk_service' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_service' =>  'Servicio',
            'fk_users_cliente' => 'Cliente',
            'fk_payments' => 'Pagos',
            'fkPayments.fecha' => 'Fecha de Pago',
            'fkPayments.monto' => 'Monto de Pago ($)',
            'fkPayments.estatus' => 'Estado de Pago',
            'servicio' =>  'Servicio',
            'cliente' => 'Cliente',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIgualasPayments()
    {
        return $this->hasMany(IgualasPayments::className(), ['fk_servicio_payment' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPayments()
    {
        return $this->hasOne(Payments::className(), ['id' => 'fk_payments']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUsersCliente()
    {
        return $this->hasOne(PerfilUsuario::className(), ['id' => 'fk_users_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkService()
    {
        return $this->hasOne(Servicios::className(), ['id' => 'fk_service']);
    }
}
