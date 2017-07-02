<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "especializacion".
 *
 * @property integer $id
 * @property boolean $nombre
 * @property string $descripcion
 * @property boolean $activo
 *
 * @property PreguntaEspecializacion[] $preguntaEspecializacions
 */
class Especializacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'especializacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion', 'activo'], 'required'],
            [['nombre', 'activo'], 'boolean'],
            [['descripcion'], 'string'],
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
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreguntaEspecializacions()
    {
        return $this->hasMany(PreguntaEspecializacion::className(), ['fk_especialidad' => 'id']);
    }
}
