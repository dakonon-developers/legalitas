<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perfil_abogado".
 *
 * @property integer $id
 * @property string $nombres
 * @property string $apellidos
 * @property string $documento_identidad
 * @property string $foto_documento_identidad
 * @property string $exequatur
 * @property string $num_carnet
 * @property string $foto_carnet
 * @property string $telefono_oficina
 * @property string $celular
 * @property string $cv_adjunto
 * @property boolean $tipo_abogado
 * @property boolean $activo
 * @property integer $fk_nacionalidad
 * @property integer $fk_municipio
 * @property integer $fk_usuario
 *
 * @property Municipio $fkMunicipio
 * @property Nacionalidad $fkNacionalidad
 * @property User $fkUsuario
 */
class PerfilAbogado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfil_abogado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombres', 'apellidos', 'documento_identidad', 'foto_documento_identidad', 'exequatur', 'num_carnet', 'foto_carnet', 'telefono_oficina', 'celular', 'cv_adjunto', 'tipo_abogado', 'activo', 'fk_nacionalidad', 'fk_municipio', 'fk_usuario'], 'required'],
            [['tipo_abogado', 'activo'], 'boolean'],
            [['fk_nacionalidad', 'fk_municipio', 'fk_usuario'], 'integer'],
            [['nombres', 'apellidos'], 'string', 'max' => 50],
            [['documento_identidad', 'exequatur', 'num_carnet'], 'string', 'max' => 14],
            [['foto_documento_identidad', 'foto_carnet', 'cv_adjunto'], 'string', 'max' => 128],
            [['telefono_oficina', 'celular'], 'string', 'max' => 10],
            [['exequatur'], 'unique'],
            [['fk_usuario'], 'unique'],
            [['num_carnet'], 'unique'],
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
            'exequatur' => 'Exequatur',
            'num_carnet' => 'Num Carnet',
            'foto_carnet' => 'Foto Carnet',
            'telefono_oficina' => 'Telefono Oficina',
            'celular' => 'Celular',
            'cv_adjunto' => 'Cv Adjunto',
            'tipo_abogado' => 'Tipo Abogado',
            'activo' => 'Activo',
            'fk_nacionalidad' => 'Nacionalidad',
            'fk_municipio' => 'Municipio',
            'fk_usuario' => 'Usuario',
        ];
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
