<?php

namespace app\controllers;

use Yii;
use app\models\Consulta;
use app\models\ConsultaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets'.DIRECTORY_SEPARATOR.'paypalFunctions.php';
header('Content-Type: application/json');

/**
 * ConsultaController implements the CRUD actions for Consulta model.
 */
class ConsultaController extends Controller
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
                        'actions' => ['create', 'pre-create','view'],
                        'allow' => true,
                        'roles' => ['Usuario'],
                    ],
                    [
                        'actions' => ['index','asignar'],
                        'allow' => true,
                        'roles' => ['Admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Consulta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConsultaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Consulta model.
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
     * Creates a new Consulta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionPreCreate($categoria, $servicio){
        $user = Yii::$app->user;
        // $payments = new \app\models\Payments::find()->where(['fk_usuario'=>$user->id, '']);
        // falta verificar si el usuario tiene pagos pendientes o eliminar el payment con estatus
        // solicitado si es que vamos a crear un nuevo payment con el mismo estatus
        $perfil = \app\models\PerfilUsuario::find()->where(['fk_usuario'=>$user->id])->one();;
        $url="consulta/create?categoria=".$categoria;
        $servicio = \app\models\Servicios::find()->where(['id'=>$servicio])->one();
        $iguala_usuario = \app\models\IgualasUsers::find()->where(['fk_users_cliente'=>$perfil->id, 'estatus'=>'concretado'])->one();
        $extra_info = "";
        if ($iguala_usuario){
            // calcualamos con descuento:
            if ($iguala_usuario->slim=="1"){
                $extra_info = "incluyendo el descuento de slim";
              $precio = $servicio->costo - ($servicio->costo * ($servicio->servicioPromocion->fkPromocion->slim / 100));
            }
            if ($iguala_usuario->med=="1"){
              $extra_info = "incluyendo el descuento de med";
              $precio = $servicio->costo - ($servicio->costo * ($servicio->servicioPromocion->fkPromocion->med / 100));
            }
            if ($iguala_usuario->plus=="1"){
                $extra_info = "incluyendo el descuento de plus";
              $precio = $servicio->costo - ($servicio->costo * ($servicio->servicioPromocion->fkPromocion->plus / 100));
            }
        }
        else{
            $precio = $servicio->costo;
        }
        
        $description = "Solicitud de servicio: ".$servicio->nombre. " ".$extra_info;
        $paypal_charge = chargeToCustomer($precio, $description, $url);
        json_decode($paypal_charge, true);
        $charge = new \app\models\Payments();
        $charge->charge_id = $paypal_charge->id;
        $charge->monto = $precio;
        $charge->fecha = time();
        $charge->estatus = "solicitado";
        $charge->approval_link = $paypal_charge->getApprovalLink();
        $charge->fk_usuario = $user->id;
        if (!$charge->save()){
            return false;
        }
        return $this->render('preCreate', [
            'approvalUrl'=>$paypal_charge->getApprovalLink()
        ]);

    }
    public function actionCreate($categoria)
    {
        $model = new Consulta();
        $request = Yii::$app->request;
        $payment_id = $request->get('paymentId');
        $payment = getPaymentInfo($payment_id);
        // echo($payment->transactions[0]);die();
        $success = false;
        if ($payment->state == "created"){
            $charge = \app\models\Payments::find()->where(['charge_id'=> $payment->id])->one();
            $charge->estatus="concretado";
            $charge->save();
            Yii::$app->getSession()->setFlash('success','Pago realizado satisfactoriamente');
            $success = true;

            $perfil = \app\models\PerfilUsuario::find()->where(['fk_usuario'=>Yii::$app->user->id])->one();
            // Se búsca la iguala a la que esta suscrito el usuario
            $iguala_usuario = \app\models\IgualasUsers::find()->where(['fk_users_cliente'=>$perfil->id])->one();
            if($iguala_usuario)
            {
                $this->validateParticipation($perfil,$categoria,$iguala_usuario);
            }

            if ($model->load(Yii::$app->request->post())) {
                $model->fk_servicio = $categoria;
                $model->fk_cliente = $perfil->id;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
            }
        }
        else{
            Yii::$app->getSession()->setFlash('warning','Error al realizar el pago');
        }
        return $this->render('create', [
            'model' => $model,
            'payment'=>$payment,
            'success'=>$success
        ]);

        
    }

    private function validateParticipation($perfil,$categoria,$iguala)
    {
        // Se buscan los dias que tiene el mes, el mes actual y año en curso
        $end_day = date('t');
        $current_month = date('m');
        $current_year = date('Y');
        // Se hacen los formatos de la fecha inicio y fin
        $inicio = strtotime($current_year.'-'.$current_month.'-01 00:00:00');
        $fin = strtotime($current_year.'-'.$current_month.'-'.$end_day.' 00:00:00');
        // Se evalua que el servicio solicitado este dentro de la iguala del usuario
        if(!$iguala->fkIguala->getFkServicios()->where(['id'=>$categoria])->all()){
            return false;
        }
        // Se hace la consulta de las consultas en el mes
        $consultas = Consulta::find()->where(['between','creado_en',$inicio,$fin,
            'fk_cliente'=>$perfil->id,'fk_servicio'=>$categoria])->count();
        $duracion = 0;
        if($iguala->slim==1){
            $duracion = $iguala->fkIguala->slim_duracion;
        }
        else if($iguala->med==1){
            $duracion = $iguala->fkIguala->med_duracion;
        }
        else{
            $duracion = $iguala->fkIguala->plus_duracion;   
        }
        if($consultas < $duracion){
            return true;
        }
        else{
            return false;
        }

    }

    /**
     * Updates an existing Consulta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Consulta model.
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
     * Deletes an existing Consulta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAsignar($id)
    {     
        $abogados = \app\models\PerfilAbogado::find()->all();
        if (count(Yii::$app->request->post())>1) {
            $consulta = \app\models\Consulta::findOne($id);
            $consulta->fk_abogado_asignado = Yii::$app->request->post()['Abogados'];
            $consulta->save();
            Yii::$app->getSession()->setFlash('success',"Se asignó el abogado al caso con éxito.");
            $abogado = \app\models\PerfilAbogado::findOne($consulta->fk_abogado_asignado);
            //Se crea una notificación por correo
            \Yii::$app->mailer->compose()
                ->setTo($abogado->fkUsuario->email)
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                ->setSubject('Asignación a Consulta')
                ->setTextBody("
                Se te asignó a la consulta consulta".$consulta->pregunta
                .", para ver más información da click en el siguiente enlace:  ".
                Yii::$app->urlManager->createAbsoluteUrl(
                    ['site/actuaciones']
                )
                )
                ->send();
            return $this->redirect(['index']);
        } 
        
        return $this->render('asignar',[
            'id' => $id,
            'abogados' => $abogados,
        ]);
    }

    /**
     * Finds the Consulta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Consulta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Consulta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
