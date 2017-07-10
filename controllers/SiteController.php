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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
            $model->foto_documento_identidad_string = UploadModel::upload(UploadedFile::getInstance($model, 'foto_documento_identidad'),
                $model->documento_identidad);
            if($model->foto_documento_identidad_string!=''){
                $model->save();
                Yii::$app->session->setFlash('success', 'Se registro con éxito.');
                return $this->render('index'); 
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

    public function actionAbogadoRegister(){

        $model = new AbogadoForm();
        $nacionalidad = \app\models\Nacionalidad::find()->all();
        $provincia = \app\models\Provincia::find()->all();
        $municipio = \app\models\Municipio::find()->all();
        $especializacion = \app\models\Especializacion::find()->where(['activo'=>true])
        ->all();

        /*if ($model->setAttributes(Yii::$app->request->post()) && $model->validate()) {
            pass;
        }*/

        return $this->render('abogadoRegister', [
            'model' => $model,
            'nacionalidad' => $nacionalidad,
            'provincia' => $provincia,
            'municipio' => $municipio,
            'especializacion' => $especializacion,
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
        $user = User::findByAccessToken($key);
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
     * Displays servicios info.
     *
     * @return string
     */
    public function actionServicios()
    {
        return $this->render('serviciosInfo');
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
}
