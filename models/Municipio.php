<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipio".
 *
 * @property integer $id
 * @property integer $fk_provincia
 * @property string $nombre
 *
 * @property Provincia $fkProvincia
 * @property PerfilUsuario $perfilUsuario
 */
class Municipio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'municipio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_provincia', 'nombre'], 'required'],
            [['fk_provincia'], 'integer'],
            [['nombre'], 'string', 'max' => 128],
            [['fk_provincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['fk_provincia' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_provincia' => 'Provincia',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkProvincia()
    {
        return $this->hasOne(Provincia::className(), ['id' => 'fk_provincia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilUsuario()
    {
        return $this->hasOne(PerfilUsuario::className(), ['fk_municipio' => 'id']);
    }
}
