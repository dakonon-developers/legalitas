<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "consulta".
 *
 * @property integer $id
 * @property integer $fk_cliente
 * @property integer $fk_servicio
 * @property integer $fk_abogado_asignado
 * @property string $pregunta
 * @property string $archivo
 * @property integer $finalizado
 * @property string $creado_en
 * @property string $fecha_fin
 *
 * @property Calificacion $calificacion
 * @property CalificarServicio $calificarServicio
 * @property PerfilAbogado $fkAbogadoAsignado
 * @property PerfilUsuario $fkCliente
 * @property Servicios $fkServicio
 * @property Dudas[] $dudas
 * @property RespuestaConsulta[] $respuestaConsultas
 * @property PerfilAbogado[] $fkAbogados
 */
class Consulta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consulta';
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['creado_en'],
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
            [['fk_cliente', 'fk_servicio', 'pregunta'], 'required'],
            [['fk_cliente', 'fk_servicio', 'fk_abogado_asignado', 'finalizado'], 'integer'],
            [['pregunta'], 'string'],
            [['creado_en', 'fecha_fin'], 'safe'],
            [['archivo'], 'string', 'max' => 128],
            [['fk_abogado_asignado'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilAbogado::className(), 'targetAttribute' => ['fk_abogado_asignado' => 'id']],
            [['fk_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilUsuario::className(), 'targetAttribute' => ['fk_cliente' => 'id']],
            [['fk_servicio'], 'exist', 'skipOnError' => true, 'targetClass' => Servicios::className(), 'targetAttribute' => ['fk_servicio' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_cliente' => 'Cliente',
            'fk_servicio' => 'Servicio',
            'fk_abogado_asignado' => 'Abogado Asignado',
            'pregunta' => 'Pregunta',
            'archivo' => 'Archivo',
            'finalizado' => 'Finalizado',
            'creado_en' => 'Creado En',
            'fecha_fin' => 'Fecha Fin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacion()
    {
        return $this->hasOne(Calificacion::className(), ['fk_consulta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificarServicio()
    {
        return $this->hasOne(CalificarServicio::className(), ['fk_consulta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkAbogadoAsignado()
    {
        return $this->hasOne(PerfilAbogado::className(), ['id' => 'fk_abogado_asignado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkCliente()
    {
        return $this->hasOne(PerfilUsuario::className(), ['id' => 'fk_cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkServicio()
    {
        return $this->hasOne(Servicios::className(), ['id' => 'fk_servicio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDudas()
    {
        return $this->hasMany(Dudas::className(), ['fk_consulta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestaConsultas()
    {
        return $this->hasMany(RespuestaConsulta::className(), ['fk_consulta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkAbogados()
    {
        return $this->hasMany(PerfilAbogado::className(), ['id' => 'fk_abogado'])->viaTable('respuesta_consulta', ['fk_consulta' => 'id']);
    }
}
