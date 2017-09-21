<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "respuesta_consulta".
 *
 * @property integer $id
 * @property string $texto
 * @property string $adjunto
 * @property string $fecha
 * @property integer $fk_abogado
 * @property integer $fk_consulta
 *
 * @property PerfilAbogado $fkAbogado
 * @property Consulta $fkConsulta
 */
class RespuestaConsulta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'respuesta_consulta';
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
            [['fecha'], 'safe'],
            [['fk_abogado', 'fk_consulta'], 'integer'],
            [['adjunto'], 'string', 'max' => 128],
            [['fk_abogado', 'fk_consulta'], 'unique', 'targetAttribute' => ['fk_abogado', 'fk_consulta'], 'message' => 'The combination of Fk Abogado and Fk Consulta has already been taken.'],
            [['fk_abogado'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilAbogado::className(), 'targetAttribute' => ['fk_abogado' => 'id']],
            [['fk_consulta'], 'exist', 'skipOnError' => true, 'targetClass' => Consulta::className(), 'targetAttribute' => ['fk_consulta' => 'id']],
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
            'fecha' => 'Fecha',
            'fk_abogado' => 'Abogado',
            'fk_consulta' => 'Consulta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkAbogado()
    {
        return $this->hasOne(PerfilAbogado::className(), ['id' => 'fk_abogado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkConsulta()
    {
        return $this->hasOne(Consulta::className(), ['id' => 'fk_consulta']);
    }
}
