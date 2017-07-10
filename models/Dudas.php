<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dudas".
 *
 * @property integer $id
 * @property string $texto
 * @property string $adjunto
 * @property integer $leido
 * @property string $fecha
 * @property integer $fk_user
 * @property integer $fk_consulta
 *
 * @property Consulta $fkConsulta
 * @property User $fkUser
 */
class Dudas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dudas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['texto', 'fk_user', 'fk_consulta'], 'required'],
            [['texto'], 'string'],
            [['leido', 'fk_user', 'fk_consulta'], 'integer'],
            [['fecha'], 'safe'],
            [['adjunto'], 'string', 'max' => 128],
            [['fk_consulta'], 'exist', 'skipOnError' => true, 'targetClass' => Consulta::className(), 'targetAttribute' => ['fk_consulta' => 'id']],
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
            'texto' => 'Texto',
            'adjunto' => 'Adjunto',
            'leido' => 'Leido',
            'fecha' => 'Fecha',
            'fk_user' => 'Fk User',
            'fk_consulta' => 'Fk Consulta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkConsulta()
    {
        return $this->hasOne(Consulta::className(), ['id' => 'fk_consulta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUser()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_user']);
    }
}
