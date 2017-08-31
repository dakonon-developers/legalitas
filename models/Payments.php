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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['charge_id', 'monto', 'fecha', 'fk_usuario'], 'required'],
            [['monto'], 'number'],
            [['fecha', 'fk_usuario'], 'integer'],
            [['charge_id'], 'string', 'max' => 25],
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
            'charge_id' => 'ID Cargo',
            'monto' => 'Monto',
            'fecha' => 'Fecha',
            'fk_usuario' => 'Usuario',
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
