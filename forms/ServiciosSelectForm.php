<?php

namespace app\forms;

use Yii;
use yii\base\Model;

/**
 * ServiciosSelectForm formulario para seleccionar un servicio.
 *
 *
 */
class ServiciosSelectForm extends Model
{
    public $servicios;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['servicios', 'required'],
            [['servicios'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Servicios::className(), 'targetAttribute' => ['servicios' => 'id']],

        ];
    }

}