<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "familia".
 *
 * @property integer $id
 * @property string $miembro
 * @property string $tipo
 * @property integer $fk_perfil_usuario
 *
 * @property PerfilUsuario $fkPerfilUsuario
 */
class Familia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'familia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['miembro', 'tipo', 'fk_perfil_usuario'], 'required'],
            [['fk_perfil_usuario'], 'integer'],
            [['miembro'], 'string', 'max' => 100],
            [['tipo'], 'string', 'max' => 2],
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
            'miembro' => 'Miembro',
            'tipo' => 'Tipo',
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
