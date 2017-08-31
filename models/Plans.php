<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plans".
 *
 * @property integer $id
 * @property string $plan_id
 * @property string $nombre
 * @property string $descripcion
 * @property double $precio
 * @property string $intervalo
 */
class Plans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['precio'], 'number'],
            [['precio', 'intervalo'], 'safe'],
            [['plan_id', 'nombre', 'descripcion'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plan_id' => 'Plan ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'precio' => 'Precio',
            'intervalo' => 'Intervalo',
        ];
    }
}
