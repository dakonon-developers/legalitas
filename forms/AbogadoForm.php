<?php
namespace app\forms;

use yii\base\Model;

/**
 * Usuario form
 */
class AbogadoForm extends Model
{
    // Model Users
    public $username;
    public $email;
    public $password;
    public $password_repeat;

    // Model Perfil
    public $nombres;
    public $apellidos;
    public $documento_identidad;
    public $foto_documento_identidad;
    public $exequatur;
    public $num_carnet;
    public $telefono_oficina;
    public $celular;
    public $cv_adjunto;
    public $tipo_abogado;
    public $fk_nacionalidad;
    public $fk_municipio;
    public $provincia;
    public $fk_usuario;

    // Modelo Preguntas Perfil
    public $demandado;
    public $cantidad;
    public $consulta_info;
    public $servicios;

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password'],

            [['nombres', 'apellidos', 'documento_identidad', 'foto_documento_identidad', 'exequatur',  'num_carnet', 'telefono_oficina', 'celular', 'cv_adjunto', 'fk_nacionalidad', 'fk_municipio', 'fk_usuario'], 'required'],
            [['fk_nacionalidad', 'fk_municipio', 'fk_usuario'], 'integer'],
            [['nombres', 'apellidos'], 'string', 'max' => 50],
            [['documento_identidad'], 'string', 'max' => 14],
            [['foto_documento_identidad'], 'string', 'max' => 128],
            [['exequatur'], 'string', 'max' => 28],
            [['num_carnet'], 'string', 'max' => 28],
            [['telefono_oficina', 'celular'], 'string', 'max' => 10],
            [['cv_adjunto'], 'string', 'max' => 128],
            [['fk_municipio'], 'unique'],
            [['fk_nacionalidad'], 'unique'],
            [['fk_usuario'], 'unique'],
            [['fk_municipio'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Municipio::className(), 'targetAttribute' => ['fk_municipio' => 'id']],
            [['fk_nacionalidad'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Nacionalidad::className(), 'targetAttribute' => ['fk_nacionalidad' => 'id']],
            [['fk_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['fk_usuario' => 'id']],

            // Preguntas
            [['demandado', 'consulta_info','servicios'], 'required'],
            [['demandado', 'consulta_info'], 'boolean'],
            [['cantidad'], 'integer'],
            [['cantidad'],'required', 'when' => function($model) {
                return $model->consulta_info == "1";},
                'whenClient' => "function (attribute, value) {
                    return $('.field-abogadoform-demandado input[type=\'radio\']:checked').val() == \"1\";
                }" ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Nombre de Usuario',
            'email' => 'Correo',
            'password' => 'Contraseña',
            'password_repeat' => 'Repita su contraseña',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'documento_identidad' => 'Documento de Identidad',
            'foto_documento_identidad' => 'Foto Documento Identidad',
            'exequatur' => 'Exequatur',
            'num_carnet' => 'Numero de Carnet',
            'telefono_oficina' => 'Telefono Oficina',
            'celular' => 'Celular',
            'cv_adjunto' => 'Adjuntar Curriculum Vitae',
            'tipo_abogado' => 'Tipo de Abogado',
            'fk_nacionalidad' => 'Nacionalidad',
            'fk_municipio' => 'Municipio',
            'fk_usuario' => 'Usuario',
            // Preguntas
            'demandado' => 'Demandado',
            'cantidad' => 'Cantidad',
            'consulta_info' => 'Info',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
