<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "payments".
 *
 * @property integer $id
 * @property string $charge_id
 * @property string $estatus 
 * @property string $approval_link
 * @property double $monto
 * @property integer $fecha
 * @property integer $fk_usuario
 *
 * @property User $fkUsuario
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
     * @behaviors
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['fecha'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['charge_id', 'estatus', 'monto', 'fecha', 'fk_usuario'], 'required'],
            [['monto'], 'number'],
            [['fecha', 'fk_usuario'], 'integer'],
            [['payment_usado', 'confirmado'], 'boolean'],
            [['estatus'], 'string', 'max' => 25],
            [['charge_id'], 'string', 'max' => 255],
            [['approval_link'], 'string', 'max' => 255],
            [['fk_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_usuario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'charge_id' => 'Cargo',
            'estatus' => 'Estado',
            'approval_link' => 'Link aprovatorio',
            'monto' => 'Monto ($)',
            'fecha' => 'Fecha',
            'fk_usuario' => 'Usuario',
            'username' => 'Usuario',
            'payment_usado' => 'Pago usado'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicioPayments()
    {
        return $this->hasMany(ServicioPayments::className(), ['fk_payments' => 'id']);
    }
}
