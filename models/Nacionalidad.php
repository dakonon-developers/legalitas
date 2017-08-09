<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nacionalidad".
 *
 * @property integer $id
 * @property integer $fk_pais
 * @property string $nombre
 * @property string $abreviatura
 *
 * @property Pais $fkPais
 * @property PerfilUsuario $perfilUsuario
 */
class Nacionalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nacionalidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_pais', 'nombre', 'abreviatura'], 'required'],
            [['fk_pais'], 'integer'],
            [['nombre'], 'string', 'max' => 128],
            [['abreviatura'], 'string', 'max' => 3],
            [['fk_pais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['fk_pais' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_pais' => 'Fk Pais',
            'nombre' => 'Nombre',
            'abreviatura' => 'Abreviatura',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'fk_pais']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilUsuario()
    {
        return $this->hasOne(PerfilUsuario::className(), ['fk_nacionalidad' => 'id']);
    }
}
