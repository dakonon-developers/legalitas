<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "igualas".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $slim_duracion
 * @property integer $med_duracion
 * @property integer $plus_duracion
 * @property double $slim
 * @property double $med
 * @property double $plus
 * @property string $slim_paypal_id
 * @property string $med_paypal_id
 * @property string $plus_paypal_id
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
            [['slim_paypal_id', 'med_paypal_id','plus_paypal_id'], 'string'],
            [['slim_duracion', 'med_duracion', 'plus_duracion'], 'integer'],
            //[['slim', 'med', 'plus'], 'number'],
            [['nombre'], 'string', 'max' => 255],
            // [['slim_stripe', 'med_stripe', 'plus_stripe'], 'string', 'max' => 25],
            // [['med_stripe'], 'unique'],
            [['nombre'], 'unique'],
            // [['plus_stripe'], 'unique'],
            // [['slim_stripe'], 'unique'],
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
            'slim_duracion' => 'Slim Duracion',
            'med_duracion' => 'Med Duracion',
            'plus_duracion' => 'Plus Duracion',
            'slim' => 'Slim',
            'med' => 'Med',
            'plus' => 'Plus',
            'slim_paypal_id' => 'Slim PayPal id',
            'med_paypal_id' => 'Med PayPal id',
            'plus_paypal_id' => 'Plus PayPal id',
        ];
    }
}
