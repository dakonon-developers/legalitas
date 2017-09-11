<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "igualas_users".
 *
 * @property integer $id
 * @property integer $fk_iguala
 * @property integer $fk_users_cliente
 * @property integer $slim
 * @property integer $med
 * @property integer $plus
 *
 * @property Igualas $fkIguala
 * @property PerfilUsuario $fkUsersCliente
 */
class IgualasUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'igualas_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_iguala', 'fk_users_cliente'], 'required'],
            [['fk_iguala', 'fk_users_cliente', 'slim', 'med', 'plus'], 'integer'],
            [['fk_iguala', 'fk_users_cliente'], 'unique', 'targetAttribute' => ['fk_iguala', 'fk_users_cliente'], 'message' => 'The combination of Fk Iguala and Fk Users Cliente has already been taken.'],
            [['fk_iguala'], 'exist', 'skipOnError' => true, 'targetClass' => Igualas::className(), 'targetAttribute' => ['fk_iguala' => 'id']],
            [['fk_users_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilUsuario::className(), 'targetAttribute' => ['fk_users_cliente' => 'id']],
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
            'fk_users_cliente' => 'Fk Users Cliente',
            'slim' => 'Slim',
            'med' => 'Med',
            'plus' => 'Plus',
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
    public function getFkUsersCliente()
    {
        return $this->hasOne(PerfilUsuario::className(), ['id' => 'fk_users_cliente']);
    }
}
