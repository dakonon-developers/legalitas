<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicio_promocion".
 *
 * @property integer $fk_servicio
 * @property integer $fk_promocion
 *
 * @property Promociones $fkPromocion
 * @property Servicios $fkServicio
 */
class ServicioPromocion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'servicio_promocion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_servicio', 'fk_promocion'], 'required'],
            [['fk_servicio', 'fk_promocion'], 'integer'],
            [['fk_servicio', 'fk_promocion'], 'unique', 'targetAttribute' => ['fk_servicio', 'fk_promocion'], 'message' => 'The combination of Fk Servicio and Fk Promocion has already been taken.'],
            [['fk_promocion'], 'exist', 'skipOnError' => true, 'targetClass' => Promociones::className(), 'targetAttribute' => ['fk_promocion' => 'id']],
            [['fk_servicio'], 'exist', 'skipOnError' => true, 'targetClass' => Servicios::className(), 'targetAttribute' => ['fk_servicio' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fk_servicio' => 'Fk Servicio',
            'fk_promocion' => 'Fk Promocion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPromocion()
    {
        return $this->hasOne(Promociones::className(), ['id' => 'fk_promocion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkServicio()
    {
        return $this->hasOne(Servicios::className(), ['id' => 'fk_servicio']);
    }
}
