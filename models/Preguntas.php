<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "preguntas".
 *
 * @property integer $id
 * @property boolean $demandado
 * @property integer $cantidad
 * @property boolean $consulta_info
 * @property integer $fk_user
 *
 * @property PreguntaEspecializacion[] $preguntaEspecializacions
 * @property User $fkUser
 */
class Preguntas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preguntas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['demandado', 'cantidad', 'consulta_info', 'fk_user'], 'required'],
            [['demandado', 'consulta_info'], 'boolean'],
            [['cantidad', 'fk_user'], 'integer'],
            [['fk_user'], 'unique'],
            [['fk_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'demandado' => 'Demandado',
            'cantidad' => 'Cantidad',
            'consulta_info' => 'Consulta Info',
            'fk_user' => 'Fk User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreguntaEspecializacions()
    {
        return $this->hasMany(PreguntaEspecializacion::className(), ['fk_pregunta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUser()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_user']);
    }
}
