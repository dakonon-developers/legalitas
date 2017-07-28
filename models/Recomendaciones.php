<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recomendaciones".
 *
 * @property integer $id
 * @property integer $fk_calificacion_servicio
 * @property string $correo
 * @property string $telefono
 *
 * @property CalificarServicio $fkCalificacionServicio
 */
class Recomendaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recomendaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['correo', 'telefono'], 'required'],
            [['fk_calificacion_servicio'], 'integer'],
            [['correo', 'telefono'], 'string', 'max' => 255],
            [['fk_calificacion_servicio'], 'exist', 'skipOnError' => true, 'targetClass' => CalificarServicio::className(), 'targetAttribute' => ['fk_calificacion_servicio' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_calificacion_servicio' => 'Fk Calificacion Servicio',
            'correo' => 'Correo',
            'telefono' => 'Telefono',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkCalificacionServicio()
    {
        return $this->hasOne(CalificarServicio::className(), ['id' => 'fk_calificacion_servicio']);
    }
}
