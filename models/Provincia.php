<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provincia".
 *
 * @property integer $id
 * @property integer $fk_pais
 * @property string $nombre
 *
 * @property Municipio[] $municipios
 * @property Pais $fkPais
 */
class Provincia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provincia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_pais', 'nombre'], 'required'],
            [['fk_pais'], 'integer'],
            [['nombre'], 'string', 'max' => 128],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipios()
    {
        return $this->hasMany(Municipio::className(), ['fk_provincia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'fk_pais']);
    }
}
