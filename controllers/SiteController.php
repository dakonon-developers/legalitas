<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use app\forms\LoginForm;
use app\forms\UsuarioForm;
use app\forms\AbogadoForm;
use app\models\UploadModel;
use app\forms\PasswordResetRequestForm;
use app\forms\ResetPasswordForm;
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets'.DIRECTORY_SEPARATOR.'paypalFunctions.php';

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','actuaciones','mail'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['actuaciones'],
                        'allow' => true,
                        'roles' => ['Usuario','Abogado Interno','Abogado Externo'],
                    ],
                    [
                        'actions' => ['mail'],
                        'allow' => true,
                        'roles' => ['Admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Registra el usuario.
     *
     * @return render
     */
    public function actionUserRegister(){

        $model = new UsuarioForm();
        $nacionalidad = \app\models\Nacionalidad::find()->all();
        $provincia = \app\models\Provincia::find()->all();
        $municipio = \app\models\Municipio::find()->all();
        $especializacion = \app\models\Especializacion::find()->where(['activo'=>true])
        ->all();


        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $uploads = new UploadModel();
            $model->foto_documento_identidad_string = $uploads->upload(UploadedFile::getInstance($model, 'foto_documento_identidad'),
                $model->documento_identidad);
            if($model->foto_documento_identidad_string!=''){
                   
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Se registro con éxito, verifique su correo.');
                    $charge = \app\models\Payments::find()->where(['fk_usuario'=>$model->id])->one();
                    return $this->render('userRegisterStepTwo',['charge'=>$charge]);
                }
                else{
                    Yii::$app->getSession()->setFlash('warning','Ocurrió un error en el registro');
                }
            }

            Yii::$app->session->setFlash('error', 'Debe adjuntar un documento.');
        }
        
        return $this->render('userRegister', [
            'model' => $model,
            'nacionalidad' => $nacionalidad,
            'provincia' => $provincia,
            'municipio' => $municipio,
            'especializacion' => $especializacion,
        ]);
    }

    /**
     * Registra el abogado.
     *
     * @return render
     */
    public function actionAbogadoRegister(){

        $model = new AbogadoForm();
        $nacionalidad = \app\models\Nacionalidad::find()->all();
        $provincia = \app\models\Provincia::find()->all();
        $municipio = \app\models\Municipio::find()->all();
        $especializacion = \app\models\Especializacion::find()->where(['activo'=>true])
        ->all();

       if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $uploads = new UploadModel();
            $model->foto_documento_identidad_string = $uploads->upload(UploadedFile::getInstance($model, 'foto_documento_identidad'),
                $model->documento_identidad);
            $model->foto_carnet_string = $uploads->upload(UploadedFile::getInstance($model, 'foto_carnet'),
                $model->documento_identidad);
            $model->cv_adjunto_string = $uploads->upload(UploadedFile::getInstance($model, 'cv_adjunto'),
                $model->documento_identidad);
            if($model->foto_documento_identidad_string !='' and $model->foto_carnet_string !='' and $model->cv_adjunto_string !=''){
                $model->save();
                if($model->email){
                    Yii::$app->session->setFlash('success', 'Se registró con éxito, verifique su correo.');
                    }
                    else{
                    Yii::$app->getSession()->setFlash('warning','Falló, contacte al administrador del sitio!');
                    }
                return $this->render('index');
            }
            Yii::$app->session->setFlash('error', 'Debe adjuntar un documento.');
        }

        return $this->render('abogadoRegister', [
            'model' => $model,
            'nacionalidad' => $nacionalidad,
            'provincia' => $provincia,
            'municipio' => $municipio,
            'especializacion' => $especializacion,
        ]);
    }

    /**
     * Visualiza actuaciones.
     * @return mixed
     */
    public function actionActuaciones()
    {
        if(Yii::$app->user->can('Usuario')){
            $searchModel = new \app\models\ActuacionSearch(['user'=>Yii::$app->user->id]);
        }
        else{
            $searchModel = new \app\models\ActuacionSearch(['abogado'=>Yii::$app->user->id]);
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('actuacion', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Revise su correo y siga las instrucciones.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Lo sentimos, no se puede restablecer la contraseña de ese correo.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Se salvó la nueva contraseña.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Confirma cuenta.
     *
     * @param string $key
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionConfirm($key)
    {
        $user = \app\models\User::findByAccessToken($key);
        if(!empty($user))
        {
            $user->status=10;
            $user->save();
            Yii::$app->getSession()->setFlash('success','El correo se confirmo con éxito!');
        }
        else
        {
            Yii::$app->getSession()->setFlash('warning','Ocurrió un error al confirmar el correo');
        }
        return $this->goHome();
    }

    /**
     * Displays legalitas info.
     *
     * @return string
     */
    public function actionLegalitas()
    {
        return $this->render('legalitasInfo');
    }

    /**
     * Displays contrata info.
     *
     * @return string
     */
    public function actionContrata()
    {
        return $this->render('contrataInfo');
    }

    /**
     * Ejecuta los pagos.
     *
     * @return string
     */
    public function actionExecutePayment(){
        $request = Yii::$app->request;
        $payment_id = $request->get('paymentId');
        try {
            $payment = getPaymentInfo($payment_id);
        }catch(\Exception $e){
            Yii::$app->getSession()->setFlash('danger',$e->getMessage());
            return $this->render('executePayment', ['payment'=>false]);
        }
        // echo($payment->transactions[0]);die();
        if ($payment->state == "created"){
            $charge = \app\models\Payments::find()->where(['charge_id'=> $payment->id])->one();
            $charge->estatus="concretado";
            $charge->save();
            if ($request->get('success') == "true") {
                Yii::$app->getSession()->setFlash('success','Pago realizado satisfactoriamente');
            }else{
                Yii::$app->getSession()->setFlash('warning','Error al realizar el pago');
            }
        }
        else{
            Yii::$app->getSession()->setFlash('warning','Error al realizar el pago');
        }
        return $this->render('executePayment', ['payment'=>$payment]);
    }


    /**
     * Muestra el listado de los servicios.
     *
     * @return render servicios
     */
    public function actionSolicita()
    {
        $searchModel = new \app\models\ServiciosSearch(['activo'=>true]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('servicios', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra envía correos a un listado x de usuarios.
     *
     * @return render send_mail
     */
    public function actionMail(){
        $model = new \app\forms\SendMailsForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->tipo == 1){
                if($model->email==1){
                    $mails = $this->getUsersMail(true);
                }
                else if($model->email==2){
                    $mails = $this->getUsersMail(false);
                }
                else{
                    $mails = $this->getUsersMail(false,true);   
                }
            }
            else{
                $mails = $this->getIgualasMail($model->email);
            }
            if(count($mails)>0)
            {
                if($model->sendMails($mails)){
                    Yii::$app->session->setFlash('success', 'Se enviaron los correos con éxito.');
                } else {
                    Yii::$app->session->setFlash('error', 'Lo sentimos, no se pudieron enviar correos.');
                }
            }
            else{
                Yii::$app->session->setFlash('error', 'No hay correos de usuario aquí.');
            }

        }
        $igualas = \app\models\Igualas::find()->where(['visible'=>1])->all();
        return $this->render('send_mail',[
            'model' => $model,
            'igualas' => $igualas
        ]);
    }

    /**
     * Obtiene los correos de los usuarios del sistema.
     *
     * @param $cliente Booleano para saber si es cliente o no
     * @param $all Booleano para saber si son todos los usuarios
     * @return array con los correos
     */
    public function getUsersMail($cliente,$all=false){
        if($all){
            return \yii\helpers\ArrayHelper::getColumn(\app\models\User::find()->where('"username" != \'admin\'')->asArray()->all(),'email');
        }
        if($cliente){
            return \yii\helpers\ArrayHelper::getColumn(\app\models\PerfilUsuario::find()->joinWith('fkUsuario')->asArray()->all(),'fkUsuario.email');
        }
        else{
            return \yii\helpers\ArrayHelper::getColumn(\app\models\PerfilAbogado::find()->joinWith('fkUsuario')->asArray()->all(),'fkUsuario.email');   
        }
    }

        /**
     * Obtiene los correos de los usuarios por iguala.
     *
     * @param $iguala_id Integer Recibe el id de la iguala
     * @return array con los correos
     */
    public function getIgualasMail($iguala_id){
        $query =\app\models\IgualasUsers::find()->where(['fk_iguala'=>$iguala_id])
        ->joinWith('fkUsersCliente.fkUsuario')
        ->asArray()->all();
        return \yii\helpers\ArrayHelper::getColumn($query,'fkUsersCliente.fkUsuario.email');
    }

}
