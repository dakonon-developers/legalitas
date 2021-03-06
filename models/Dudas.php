<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
     * @behaviors
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['fecha'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['texto'], 'required'],
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
            'fk_user' => 'Usuario',
            'fk_consulta' => 'Consulta',
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
