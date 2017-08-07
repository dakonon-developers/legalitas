<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calificacion".
 *
 * @property integer $id
 * @property integer $fk_consulta
 * @property string $calificacion
 *
 * @property Consulta $fkConsulta
 */
class Calificacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calificacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_consulta', 'calificacion'], 'required'],
            [['fk_consulta'], 'integer'],
            [['calificacion'], 'number'],
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
            'fk_consulta' => 'Fk Consulta',
            'calificacion' => 'Calificacion',
            'fkConsulta.fkAbogadoAsignado.documento_identidad' => 'Documento de Identidad del Abogado',
            'abogado_documento' => 'Documento de Identidad del Abogado',
            'fkConsulta.fkAbogadoAsignado.nombres' => 'Nombres y Apellidos del Abogado',
            'fkConsulta.fkCliente.documento_identidad' => 'Documento de Identidad del Cliente',
            'cliente_documento' => 'Documento de Identidad del Cliente',
            'fkConsulta.fkCliente.nombres' => 'Nombres y Apellidos del Cliente',
            'fkConsulta.fkServicio.nombre' => 'Tipo de Servicio'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkConsulta()
    {
        return $this->hasOne(Consulta::className(), ['id' => 'fk_consulta']);
    }
}
