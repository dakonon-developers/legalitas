<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicios".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $fk_materia
 * @property integer $activo
 * @property double $costo
 *
 * @property Consulta[] $consultas
 * @property Materia $fkMateria
 */
class Servicios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'servicios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'fk_materia', 'costo'], 'required'],
            [['nombre'], 'string'],
            [['fk_materia', 'activo'], 'integer'],
            [['costo'], 'number'],
            [['fk_materia'], 'exist', 'skipOnError' => true, 'targetClass' => Materia::className(), 'targetAttribute' => ['fk_materia' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'fk_materia' => 'Fk Materia',
            'activo' => 'Activo',
            'costo' => 'Costo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultas()
    {
        return $this->hasMany(Consulta::className(), ['fk_servicio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkMateria()
    {
        return $this->hasOne(Materia::className(), ['id' => 'fk_materia']);
    }
}
