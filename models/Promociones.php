<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promociones".
 *
 * @property integer $id
 * @property double $slim
 * @property double $med
 * @property double $plus
 *
 * @property ServicioPromocion[] $servicioPromocions
 * @property Servicios[] $fkServicios
 */
class Promociones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promociones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slim', 'med', 'plus'], 'required'],
            [['slim', 'med', 'plus'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slim' => 'Slim',
            'med' => 'Med',
            'plus' => 'Plus',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicioPromocions()
    {
        return $this->hasMany(ServicioPromocion::className(), ['fk_promocion' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkServicios()
    {
        return $this->hasMany(Servicios::className(), ['id' => 'fk_servicio'])->viaTable('servicio_promocion', ['fk_promocion' => 'id']);
    }
}
