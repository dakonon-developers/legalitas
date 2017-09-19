<?php

namespace app\controllers;

use Yii;
use app\models\PerfilUsuario;
use app\models\PerfilUsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets'.DIRECTORY_SEPARATOR.'paypalFunctions.php';
header('Content-Type: application/json');
/**
 * PerfilUsuarioController implements the CRUD actions for PerfilUsuario model.
 */
class PerfilUsuarioController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create','view','update', 'change-password','unsubscribe'],
                        'allow' => true,
                        'roles' => ['Usuario'],
                    ],
                    [
                        'actions' => ['index','activar','view', 'change-password'],
                        'allow' => true,
                        'roles' => ['Admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PerfilUsuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PerfilUsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PerfilUsuario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PerfilUsuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PerfilUsuario();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionChangePassword($id)
    {
        if (Yii::$app->user->id == $id){
            try {
                $changed_pass = new \app\forms\ChangePasswordForm($id);
            } catch (InvalidParamException $e) {
                throw new \yii\web\BadRequestHttpException($e->getMessage());
            }
            if ($changed_pass->load(Yii::$app->request->post()) && $changed_pass->validate() && $changed_pass->changePassword()) {
                Yii::$app->session->setFlash('success', 'Password Cambiada!');
                $model = $this->findModelbyUser($id);
                return $this->redirect(['update', 'id' => $model->fk_usuario]);
            }
            else{
                $model = $this->findModelbyUser($id);
                Yii::$app->session->setFlash('error', 'Password antigua incorrecta!');
                return $this->redirect(['update', 'id' => $model->fk_usuario]);
            }
        }
        else{
            throw new  ForbiddenHttpException("No puede ingresar a este perfil");
        }
    }

    /**
     * Updates an existing PerfilUsuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUnsubscribe(){
        $perfil = \app\models\PerfilUsuario::find()->where(['fk_usuario'=>Yii::$app->user->id])->one();
        $igualas_user_viejo = \app\models\IgualasUsers::find()->where(['fk_users_cliente'=>$perfil->id, 'estatus'=>'concretado'])->one();
        if ($igualas_user_viejo){
            $plan_viejo = \app\models\Igualas::find()->where(['id'=>$igualas_user_viejo->fk_iguala])->one();
            $agreement_viejo = paypalSuspendPlanToUser($igualas_user_viejo->subscription_id);
            // $igualas_user_viejo->delete();
            if ($agreement_viejo){
                $igualas_user_viejo->estatus = "cancelado";
                $igualas_user_viejo->save();
                Yii::$app->session->setFlash('success', 'Usted ha cancelado la subscripción correctamente.');
            }
            else{
                Yii::$app->session->setFlash('error', 'Problemas al cancelar la subscripción');
            }
        }
        return $this->redirect(['update', 'id' => Yii::$app->user->id]);
    }
    public function actionUpdate($id)
    {
        
        $nacionalidad = \app\models\Nacionalidad::find()->all();
        $provincia = \app\models\Provincia::find()->all();
        $municipio = \app\models\Municipio::find()->all();
        $model = $this->findModelbyUser($id);
        $iguala_user = \app\models\IgualasUsers::find()->where(['fk_users_cliente'=>$id, 'estatus'=>'concretado'])->one();
        $plan = false;
        if ($iguala_user) {
            $plan = \app\models\Igualas::find()->where(['id'=>$iguala_user->fk_iguala])->one();
        }

        $id = Yii::$app->user->id;
 
        try {
            $changed_pass = new \app\forms\ChangePasswordForm($id);
        } catch (InvalidParamException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }
    
        if (((Yii::$app->user->can('Usuario'))) and (Yii::$app->user->id  != $model->fk_usuario)) {
                throw new  ForbiddenHttpException("No puede ingresar a este perfil");
        }
        else{
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Se actualizo con éxito su perfil.');
                return $this->redirect(['update', 'id' => $model->fk_usuario]);
            } 
            else {
                return $this->render('update', [
                    'model' => $model,
                    'nacionalidad' => $nacionalidad,
                    'provincia' => $provincia,
                    'municipio' => $municipio,
                    'changed_pass' => $changed_pass,
                    'plan' => $plan,
                    'iguala_user' => $iguala_user,
                ]);
            }
        }
    }

    /**
    *   Funcion para permitir al usuario activar/desactivar perfiles
    *   @author Rodrigo Da Costa
    *   @date 09/07/2017
    */
    public function actionActivar($id)
    {
        $model = $this->findModel($id);
        $auth = Yii::$app->authManager;
        if($model->activo==True)
        {
            $model->activo=False;
            $auth->revokeAll($model->fk_usuario);
            $authorRole = $auth->getRole('Invitado');
            $auth->assign($authorRole, $model->fk_usuario);
            Yii::$app->getSession()->setFlash('warning',"Se desactivó el usuario.");
        }
        else
        {
            $model->activo=True;
            $auth->revokeAll($model->fk_usuario);
            $authorRole = $auth->getRole('Usuario');
            $auth->assign($authorRole, $model->fk_usuario);
            Yii::$app->getSession()->setFlash('success',"Se activó el usuario.");
            //Se crea una notificación por correo
            \Yii::$app->mailer->compose()
                ->setTo($model->fkUsuario->email)
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                ->setSubject('Activación por el admin de legalitas')
                ->setTextBody("
                Fue activado por el admin de legalitas, ya puede utilizar el sistema"
                )
                ->send();
        }
        $model->save();
        return $this->redirect('index');
    }

    /**
     * Deletes an existing PerfilUsuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PerfilUsuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PerfilUsuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PerfilUsuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
     protected function findModelbyUser($id)
    {
        if (($model = PerfilUsuario::findOne(['fk_usuario'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
