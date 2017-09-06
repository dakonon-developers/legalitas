<?php
namespace app\forms;

use Yii;
use yii\base\Model;
// use \app\widgets\paypalFunctions\chargeToCustomer;
// use \app\widgets\paypalFunctions\paypalCreateCreditCard;
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets'.DIRECTORY_SEPARATOR.'paypalFunctions.php';
header('Content-Type: application/json');
/**
 * Usuario form
 */
class UsuarioForm extends Model
{
    // User
    public $id;
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    // Profile
    public $nombres;
    public $apellidos;
    public $documento_identidad;
    public $nombre_representante;
    public $documento_identidad_representante;
    public $foto_documento_identidad;
    public $foto_documento_identidad_string;
    public $telefono_oficina;
    public $celular;
    
    public $card_type;
    public $tarjeta_credito;
    public $cvc;
    public $exp_month;
    public $exp_year;
    public $first_name;
    public $last_name;

    public $fk_nacionalidad;
    public $fk_municipio;
    public $provincia;
    public $categoria;
    // Questions
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

            [['nombres', 'apellidos', 'documento_identidad', 'telefono_oficina',
            'celular', 'first_name', 'last_name', 'card_type', 'tarjeta_credito', 'cvc', 'exp_month', 'exp_year', 'fk_nacionalidad', 'fk_municipio',
             'categoria','provincia'], 'required'],
            [['fk_nacionalidad', 'fk_municipio', 'provincia'], 'integer'],
            [['nombres', 'apellidos','nombre_representante'], 'string', 'max' => 50],
            [['documento_identidad','documento_identidad_representante'], 'string', 'max' => 14],
            [['telefono_oficina', 'celular'], 'string', 'max' => 10],
            [['tarjeta_credito', 'card_type'], 'string', 'max' => 16],
            [['first_name', 'last_name'], 'string', 'max' => 200],

            [['categoria'], 'string', 'max' => 2],
            [['nombre_representante','documento_identidad_representante'],'required', 'when' => function($model) {
                return $model->categoria == 'OA' or $model->categoria == 'NE';},
                'whenClient' => "function (attribute, value) {
                    return $('#categoria').val() == 'OA' || $('#categoria').val() == 'NE';
                }" ],
            [['fk_municipio'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Municipio::className(), 'targetAttribute' => ['fk_municipio' => 'id']],
            [['provincia'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Provincia::className(), 'targetAttribute' => ['provincia' => 'id']],
            [['fk_nacionalidad'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Nacionalidad::className(), 'targetAttribute' => ['fk_nacionalidad' => 'id']],
            //Archivo
            [['foto_documento_identidad'], 'file', 'extensions' => 'png, jpg, pdf'],
            [['foto_documento_identidad_string'], 'string', 'max' => 128],
            // Preguntas
            [['demandado', 'consulta_info','servicios'], 'required'],
            [['demandado', 'consulta_info'], 'boolean'],
            [['cantidad'], 'integer'],
            [['cantidad'],'required', 'when' => function($model) {
                return $model->consulta_info == "1";},
                'whenClient' => "function (attribute, value) {
                    return $('.field-usuarioform-demandado input[type=\'radio\']:checked').val() === \"1\";
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
            // Perfil
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'documento_identidad' => 'Documento de Identidad',
            'foto_documento_identidad' => 'Foto Documento Identidad',
            'nombre_representante' => 'Nombre Completo del Representante',
            'documento_identidad_representante' => 'Documento de Identidad del Representante',
            'telefono_oficina' => 'Telefono Oficina',
            'celular' => 'Celular',

            'card_type' => 'Tipo de tarjeta (Visa, Mastercard, etc...)',
            'tarjeta_credito' => 'Tarjeta Crédito',
            'cvc'=> 'CVC (codigo al reverso de la tarjeta)',
            'exp_month'=> 'Mes de expiración de la tarjeta',
            'exp_year'=> 'Año de expiración de la tarjeta',
            'first_name'=> 'Nombres del propietario de la tarjeta',
            'last_name'=> 'Apellidos del propietario de la tarjeta',
            
            'fk_nacionalidad' => 'Nacionalidad',
            'fk_municipio' => 'Municipio',
            'categoria' => 'Categoría',
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

        // First make charge to credit card
        $precio = new \app\models\PagosConfig;
        $precio = $precio->find()->where(['definicion'=>'primer_pago'])->one()->monto;
        $paypal_card = paypalCreateCreditCard(
            $this->card_type,
            $this->tarjeta_credito,
            $this->exp_month,
            $this->exp_year,
            $this->cvc,
            $this->first_name, 
            $this->last_name
        );
        $paypal_card_decoded = $paypal_card;
        json_decode($paypal_card_decoded, true);
// var_dump($paypal_card_decoded);
// echo '<br><br>';
// echo $paypal_card->id;
// die();
        if($paypal_card->id == null || $paypal_card->id=='')
            return false;
        // if ($paypal_card->status != "succeeded")
        //       return false;
        $paypal_charge = chargeToCustomer(
            $paypal_card,
            $paypal_card->id,
            $precio, 
            "Subscripción de ". $this->first_name. " ". $this->last_name. " a legalitas."
        );
        json_decode($paypal_charge, true);
        $charge = new \app\models\Payments();
        $charge->charge_id = $paypal_charge->id;
        $charge->monto = $precio;
        $charge->fecha = time();
        
        /*
            $stripe_customer = stripeCreateCustomer(
              $this->tarjeta_credito,
              $this->exp_month,
              $this->exp_year,
              $this->cvc
            );
            if ($stripe_customer->id == null || $stripe_customer->id == '')
              return false;
            $stripe_customer_charge = stripeChargeToCustomer(
              $stripe_customer->id,
              $precio
            );

            if ($stripe_customer_charge->status != "succeeded")
              return false;
            $charge = new \app\models\Payments();
            $charge->charge_id = $stripe_customer_charge->id;
            $charge->monto = $precio;
            $charge->fecha = time();
            $charge->save();
        */

        // Model User
        $user = new \app\models\User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = 0;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();
        $charge->fk_usuario = $user->id;
        $charge->save();
        // Model Perfil

         \Yii::$app->mailer->compose()
                ->setTo($user->email)
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                ->setSubject('Confirmacion de Registro')
                ->setTextBody("
                Persiona click en el enlace para confirmar tu registro en la paltaforma Legalitas ".
                Yii::$app->urlManager->createAbsoluteUrl(
                    ['site/confirm','key'=>$user->auth_key]
                )
                )
                ->send();
        
        $perfil = new \app\models\PerfilUsuario();
        $perfil->customer_id= $paypal_card->id;
        $perfil->nombres = $this->nombres;
        $perfil->apellidos = $this->apellidos;
        $perfil->documento_identidad = $this->documento_identidad;
        $perfil->foto_documento_identidad = $this->foto_documento_identidad_string;
        $perfil->telefono_oficina = $this->telefono_oficina;
        $perfil->celular = $this->celular;
        // $perfil->tarjeta_credito = $this->tarjeta_credito;
        $perfil->activo = 0;
        $perfil->fk_nacionalidad = $this->fk_nacionalidad;
        $perfil->fk_municipio = $this->fk_municipio;
        $perfil->fk_usuario = $user->id;
        $perfil->categoria = $this->categoria;
        $perfil->save();
        // Si la categoria lo amerita se crea el representante
        if($this->categoria=='OA' || $this->categoria=='NE'){
            $perfil_rep = new \app\models\PerfilRepresentante();
            $perfil_rep->nombre_representante = $this->nombre_representante;
            $perfil_rep->documento_identidad_representante = $this->documento_identidad_representante;
            $perfil_rep->fk_perfil_usuario = $perfil->id;
            $perfil_rep->save();
        }
        // Model de pregunta
        $pregunta = new \app\models\Preguntas();
        $pregunta->demandado = $this->demandado;
        $pregunta->cantidad = $this->cantidad ? $this->cantidad:0;
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
