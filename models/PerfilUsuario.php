<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perfil_usuario".
 *
 * @property integer $id
 * @property string $nombres
 * @property string $apellidos
 * @property string $documento_identidad
 * @property string $foto_documento_identidad
 * @property string $telefono_oficina
 * @property string $celular
 * @property string $tarjeta_credito
 * @property boolean $activo
 * @property integer $fk_nacionalidad
 * @property integer $fk_municipio
 * @property integer $fk_usuario
 * @property string $categoria
 *
 * @property PerfilRepresentante $perfilRepresentante
 * @property Municipio $fkMunicipio
 * @property Nacionalidad $fkNacionalidad
 * @property User $fkUsuario
 */
class PerfilUsuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfil_usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombres', 'apellidos', 'documento_identidad', 'foto_documento_identidad', 'telefono_oficina', 'celular', 'tarjeta_credito', 'activo', 'fk_nacionalidad', 'fk_municipio', 'fk_usuario', 'categoria'], 'required'],
            [['activo'], 'boolean'],
            [['fk_nacionalidad', 'fk_municipio', 'fk_usuario'], 'integer'],
            [['nombres', 'apellidos'], 'string', 'max' => 50],
            [['documento_identidad'], 'string', 'max' => 14],
            [['foto_documento_identidad'], 'string', 'max' => 128],
            [['telefono_oficina', 'celular'], 'string', 'max' => 10],
            [['tarjeta_credito'], 'string', 'max' => 16],
            [['categoria'], 'string', 'max' => 2],
            [['fk_usuario'], 'unique'],
            [['fk_municipio'], 'exist', 'skipOnError' => true, 'targetClass' => Municipio::className(), 'targetAttribute' => ['fk_municipio' => 'id']],
            [['fk_nacionalidad'], 'exist', 'skipOnError' => true, 'targetClass' => Nacionalidad::className(), 'targetAttribute' => ['fk_nacionalidad' => 'id']],
            [['fk_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['fk_usuario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'documento_identidad' => 'Documento Identidad',
            'foto_documento_identidad' => 'Foto Documento Identidad',
            'telefono_oficina' => 'Telefono Oficina',
            'celular' => 'Celular',
            'tarjeta_credito' => 'Tarjeta Credito',
            'activo' => 'Activo',
            'fk_nacionalidad' => 'Fk Nacionalidad',
            'fk_municipio' => 'Fk Municipio',
            'fk_usuario' => 'Fk Usuario',
            'categoria' => 'Categoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilRepresentante()
    {
        return $this->hasOne(PerfilRepresentante::className(), ['fk_perfil_usuario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkMunicipio()
    {
        return $this->hasOne(Municipio::className(), ['id' => 'fk_municipio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkNacionalidad()
    {
        return $this->hasOne(Nacionalidad::className(), ['id' => 'fk_nacionalidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'fk_usuario']);
    }
}
