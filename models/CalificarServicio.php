<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calificar_servicio".
 *
 * @property integer $id
 * @property integer $ayuda_requerimiento
 * @property integer $tiempo_respuesta
 * @property integer $nos_recomendaria
 * @property string $ayuda_requerimiento_texto
 * @property string $tiempo_respuesta_texto
 * @property string $nos_recomendaria_texto
 * @property integer $fk_consulta
 *
 * @property Consulta $fkConsulta
 * @property Recomendaciones[] $recomendaciones
 */
class CalificarServicio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calificar_servicio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ayuda_requerimiento', 'tiempo_respuesta', 'nos_recomendaria'], 'required'],
            [['ayuda_requerimiento', 'tiempo_respuesta', 'nos_recomendaria', 'fk_consulta'], 'integer'],
            [['ayuda_requerimiento_texto', 'tiempo_respuesta_texto', 'nos_recomendaria_texto'], 'string'],
            [['fk_consulta'], 'unique'],
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
            'ayuda_requerimiento' => 'Ayuda Requerimiento',
            'tiempo_respuesta' => 'Tiempo Respuesta',
            'nos_recomendaria' => 'Nos Recomendaria',
            'ayuda_requerimiento_texto' => 'Ayuda Requerimiento Texto',
            'tiempo_respuesta_texto' => 'Tiempo Respuesta Texto',
            'nos_recomendaria_texto' => 'Nos Recomendaria Texto',
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
    public function getRecomendaciones()
    {
        return $this->hasMany(Recomendaciones::className(), ['fk_calificacion_servicio' => 'id']);
    }
}
