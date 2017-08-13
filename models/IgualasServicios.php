<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "igualas_servicios".
 *
 * @property integer $fk_iguala
 * @property integer $fk_servicio
 *
 * @property Igualas $fkIguala
 * @property Servicios $fkServicio
 */
class IgualasServicios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'igualas_servicios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_iguala', 'fk_servicio'], 'required'],
            [['fk_iguala', 'fk_servicio'], 'integer'],
            [['fk_iguala', 'fk_servicio'], 'unique', 'targetAttribute' => ['fk_iguala', 'fk_servicio'], 'message' => 'The combination of Fk Iguala and Fk Servicio has already been taken.'],
            [['fk_iguala'], 'exist', 'skipOnError' => true, 'targetClass' => Igualas::className(), 'targetAttribute' => ['fk_iguala' => 'id']],
            [['fk_servicio'], 'exist', 'skipOnError' => true, 'targetClass' => Servicios::className(), 'targetAttribute' => ['fk_servicio' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fk_iguala' => 'Fk Iguala',
            'fk_servicio' => 'Fk Servicio',
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
    public function getFkServicio()
    {
        return $this->hasOne(Servicios::className(), ['id' => 'fk_servicio']);
    }
}
