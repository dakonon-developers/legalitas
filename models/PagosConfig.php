<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nacionalidad".
 *
 * @property integer $id
 * @property string $definicion
 * @property integer $monto
 * @property string $intervalo
 */
class PagosConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pagos_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['definicion', 'monto'], 'required'],
            //[['monto'], 'integer'],
            [['definicion', 'intervalo'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'definicion' => 'Definición',
            'monto' => 'Monto en DOP',
            'intervalo' => 'Intervalo, (month, day, year)',
        ];
    }

  


}
