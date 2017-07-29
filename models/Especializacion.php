<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "especializacion".
 *
 * @property integer $id
 * @property string $nombre
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
            [['descripcion'], 'string'],
            [['activo'], 'boolean'],
            [['nombre'], 'string', 'max' => 128],
            [['nombre'], 'unique'],
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
