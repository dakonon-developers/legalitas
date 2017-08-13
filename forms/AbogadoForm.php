<?php
namespace app\forms;

use Yii;
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
    public $foto_documento_identidad_string;
    public $exequatur;
    public $num_carnet;
    public $foto_carnet;
    public $foto_carnet_string;
    public $telefono_oficina;
    public $celular;
    public $cv_adjunto;
    public $cv_adjunto_string;
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
    public $otros;

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

            [['nombres', 'apellidos', 'documento_identidad', 'exequatur',  'num_carnet',  'telefono_oficina', 'celular',  'tipo_abogado','fk_nacionalidad', 'fk_municipio'], 'required'],
            [['fk_nacionalidad', 'fk_municipio', 'fk_usuario'], 'integer'],
            [['nombres', 'apellidos'], 'string', 'max' => 50],
            [['documento_identidad'], 'string', 'max' => 14],
            [['exequatur'], 'string', 'max' => 28],
            [['num_carnet'], 'string', 'max' => 28],
            [['telefono_oficina', 'celular'], 'string', 'max' => 10],
            [['fk_municipio'], 'unique' , 'targetClass' => '\app\models\PerfilAbogado' ],
            [['fk_nacionalidad'], 'unique', 'targetClass'  => '\app\models\PerfilAbogado'],
            [['fk_usuario'], 'unique',  'targetClass'  => '\app\models\PerfilAbogado'],
            [['fk_municipio'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Municipio::className(), 'targetAttribute' => ['fk_municipio' => 'id']],
            [['fk_nacionalidad'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Nacionalidad::className(), 'targetAttribute' => ['fk_nacionalidad' => 'id']],
            [['fk_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['fk_usuario' => 'id']],
            [['foto_documento_identidad'], 'file', 'extensions' => 'png, jpg, pdf','maxSize'=>1024 * 2048],
            [['foto_documento_identidad_string'], 'string', 'max' => 128],
            [['foto_carnet'], 'file', 'extensions' => 'png, jpg, pdf','maxSize'=>1024 * 2048],
            [['foto_carnet_string'], 'string', 'max' => 128],
            [['cv_adjunto'], 'file', 'extensions' => 'png, jpg, pdf','maxSize'=>1024 * 2048],
            [['cv_adjunto_string'], 'string', 'max' => 128],
        
            // Preguntas
            [['demandado', 'consulta_info','servicios'], 'required'],
            [['demandado', 'consulta_info'], 'boolean'],
            [['cantidad'], 'integer'],
            [['cantidad'],'required', 'when' => function($model) {
                return $model->consulta_info == "1";},
                'whenClient' => "function (attribute, value) {
                    return $('.field-abogadoform-demandado input[type=\'radio\']:checked').val() == \"1\";
                }" ],
            [['otros'], 'string', 'max' => 256],
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
            'foto_carnet' => 'Foto del Carnet',
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
            'otros'=>'Otros Servicios'
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
        // Model User
        $user = new \app\models\User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();
        # Sedn Mail confirm
        \Yii::$app->mailer->compose()
                ->setTo($user->email)
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                ->setSubject('Confirmacion de Registro')
                ->setTextBody("
                Persiona click en el enlace para confirma tu registro en la paltaforma Legalitas".\yii\helpers\Html::a('confirm',
                Yii::$app->urlManager->createAbsoluteUrl(
                ['site/confirm','key'=>$user->auth_key]
                ))
                )
                ->send();
         // Model Perfil
        $perfil = new \app\models\PerfilAbogado();
        $perfil->nombres = $this->nombres;
        $perfil->apellidos = $this->apellidos;
        $perfil->documento_identidad = $this->documento_identidad;
        $perfil->foto_documento_identidad = '$this->foto_documento_identidad_string';
        $perfil->exequatur = $this->exequatur;
        $perfil->num_carnet = $this->num_carnet;
        $perfil->foto_carnet = '$this->foto_carnet_string';
        $perfil->telefono_oficina = $this->telefono_oficina;
        $perfil->celular = $this->celular;
        $perfil->cv_adjunto = '$this->cv_adjunto_string';
        $perfil->tipo_abogado = $this->tipo_abogado;
        $perfil->activo = 0;
        $perfil->fk_nacionalidad = $this->fk_nacionalidad;
        $perfil->fk_municipio = $this->fk_municipio;
        $perfil->fk_usuario = $user->id;
        $perfil->save();
         // Model de pregunta
        $pregunta = new \app\models\Preguntas();
        $pregunta->demandado = $this->demandado;
        $pregunta->cantidad = $this->cantidad ? $this->cantidad :0;
        $pregunta->consulta_info = $this->consulta_info;
        $pregunta->fk_user = $user->id;
        $pregunta->save();
        //Se guardan los servicios
        if  ($this->otros != ''){
                $otros_array = preg_split("/[,]+/", $this->otros);
                foreach ($otros_array as $key => $value) {
                    $descripcion = "Describe el tipo de especialidad para el servicio legal que identifica los aspectos del tipo $value";
                    $nueva_especialidad =  new \app\models\Especializacion();
                    $nueva_especialidad->nombre = $value;
                    $nueva_especialidad->descripcion = $descripcion;
                    $nueva_especialidad->activo = 0;
                    $nueva_especialidad->save();
                    
                    $especializacion = new \app\models\PreguntaEspecializacion();
                    $especializacion->fk_pregunta = $pregunta->id;
                    $especializacion->fk_especialidad = $nueva_especialidad->id;
                    $especializacion->save();
                }
            }
        foreach ($this->servicios as $key => $value) {
            $especializacion = new \app\models\PreguntaEspecializacion();
            $especializacion->fk_pregunta = $pregunta->id;
            $especializacion->fk_especialidad = $value;
            $especializacion->save();
        }
        // Se asigna el rol
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('Invitado');
        $auth->assign($authorRole, $user->id);
        
        return true;
    }
}

