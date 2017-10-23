<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "igualas".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $slim_duracion
 * @property integer $med_duracion
 * @property integer $plus_duracion
 * @property integer $estado
 * @property integer $visible
 * @property double $slim
 * @property double $med
 * @property double $plus
 * @property string $slim_paypal_id
 * @property string $med_paypal_id
 * @property string $plus_paypal_id
 *
 * @property IgualasPayments[] $igualasPayments
 * @property IgualasServicios[] $igualasServicios
 * @property Servicios[] $fkServicios
 * @property IgualasUsers[] $igualasUsers
 * @property PerfilUsuario[] $fkUsersClientes
 */
class Igualas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'igualas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'slim', 'med', 'plus'], 'required'],
            //[['descripcion'], 'string'],
            [['slim_duracion', 'med_duracion', 'plus_duracion','estado','visible'], 'integer'],
            // [['slim', 'med', 'plus'], 'number'],
            [['nombre', 'slim_paypal_id', 'med_paypal_id', 'plus_paypal_id'], 'string', 'max' => 255],
            [['slim_paypal_id'], 'unique'],
            [['med_paypal_id'], 'unique'],
            [['plus_paypal_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'slim_duracion' => 'Slim Duración',
            'med_duracion' => 'Med Duración',
            'plus_duracion' => 'Plus Duración',
            'slim' => 'Slim',
            'med' => 'Med',
            'plus' => 'Plus',
            'slim_paypal_id' => 'Slim Paypal ID',
            'med_paypal_id' => 'Med Paypal ID',
            'plus_paypal_id' => 'Plus Paypal ID',
            'estado' => 'Estado',
            'igualasServicios' => 'Asignar Servicio a Iguala',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIgualasPayments()
    {
        return $this->hasMany(IgualasPayments::className(), ['fk_iguala' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIgualasServicios()
    {
        return $this->hasMany(IgualasServicios::className(), ['fk_iguala' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkServicios()
    {
        return $this->hasMany(Servicios::className(), ['id' => 'fk_servicio'])->viaTable('igualas_servicios', ['fk_iguala' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIgualasUsers()
    {
        return $this->hasMany(IgualasUsers::className(), ['fk_iguala' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUsersClientes()
    {
        return $this->hasMany(PerfilUsuario::className(), ['id' => 'fk_users_cliente'])->viaTable('igualas_users', ['fk_iguala' => 'id']);
    }
}
