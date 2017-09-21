<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pregunta_especializacion".
 *
 * @property integer $id
 * @property integer $fk_pregunta
 * @property integer $fk_especialidad
 *
 * @property Especializacion $fkEspecialidad
 * @property Preguntas $fkPregunta
 */
class PreguntaEspecializacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pregunta_especializacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_pregunta', 'fk_especialidad'], 'required'],
            [['fk_pregunta', 'fk_especialidad'], 'integer'],
            [['fk_especialidad'], 'exist', 'skipOnError' => true, 'targetClass' => Especializacion::className(), 'targetAttribute' => ['fk_especialidad' => 'id']],
            [['fk_pregunta'], 'exist', 'skipOnError' => true, 'targetClass' => Preguntas::className(), 'targetAttribute' => ['fk_pregunta' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_pregunta' => 'Pregunta',
            'fk_especialidad' => 'Especialidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkEspecialidad()
    {
        return $this->hasOne(Especializacion::className(), ['id' => 'fk_especialidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPregunta()
    {
        return $this->hasOne(Preguntas::className(), ['id' => 'fk_pregunta']);
    }
}
