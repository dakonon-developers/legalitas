<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perfil_representante".
 *
 * @property integer $id
 * @property string $nombre_representante
 * @property string $documento_identidad_represetntante
 * @property integer $fk_perfil_usuario
 *
 * @property PerfilUsuario $fkPerfilUsuario
 */
class PerfilRepresentante extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfil_representante';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_representante', 'documento_identidad_represetntante', 'fk_perfil_usuario'], 'required'],
            [['fk_perfil_usuario'], 'integer'],
            [['nombre_representante'], 'string', 'max' => 50],
            [['documento_identidad_represetntante'], 'string', 'max' => 14],
            [['fk_perfil_usuario'], 'unique'],
            [['fk_perfil_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilUsuario::className(), 'targetAttribute' => ['fk_perfil_usuario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_representante' => 'Nombre Representante',
            'documento_identidad_represetntante' => 'Documento Identidad Represetntante',
            'fk_perfil_usuario' => 'Fk Perfil Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPerfilUsuario()
    {
        return $this->hasOne(PerfilUsuario::className(), ['id' => 'fk_perfil_usuario']);
    }
}
