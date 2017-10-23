<?php

namespace app\controllers;

use Yii;
use app\models\Igualas;
use app\models\IgualasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets'.DIRECTORY_SEPARATOR.'stripe.php';
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets'.DIRECTORY_SEPARATOR.'paypalFunctions.php';

header('Content-Type: application/json');

/**
 * IgualasController implements the CRUD actions for Igualas model.
 */
class IgualasController extends Controller
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
                        'actions' => ['list'],
                        'allow' => true,
                        'roles' => ['@','?'],
                    ],
                    [
                        'actions' => ['index','view','create','update','delete','activar'],
                        'allow' => true,
                        'roles' => ['Admin'],
                    ],
                    [
                        'actions' => ['detail','subscribe', 'processagreement'],
                        'allow' => true,
                        'roles' => ['Usuario'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Igualas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IgualasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Igualas model.
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
     * Creates a new Igualas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Igualas();
        $servicios = \app\models\Servicios::find()->where(['activo'=>true])->all();
        $post = Yii::$app->request->post();
        if ( $model->load($post) ){
            if ($post['Igualas']['igualasServicios']==null)
            {
                Yii::$app->getSession()->setFlash('danger','Debe agregar al menos un servicio en la iguala');
            }
            else{
                $model->slim = str_replace(',', '', $model->slim);
                $model->med = str_replace(',', '', $model->med);
                $model->plus = str_replace(',', '', $model->plus);
                try {
                    $plan_slim = paypalCreatePlan($model->slim, $model->nombre, $model->nombre."-slim", "Month");
                    $plan_med = paypalCreatePlan($model->med, $model->nombre, $model->nombre."-med", "Month");
                    $plan_plus = paypalCreatePlan($model->plus, $model->nombre, $model->nombre."-plus", "Month");
                }catch(\Exception $e){
                    Yii::$app->getSession()->setFlash('danger',$e->getMessage());
                    return $this->render('create', [
                       'model' => $model,
                    ]);
                }
                $model->slim_paypal_id = $plan_slim->getId();
                $model->med_paypal_id = $plan_med->getId();
                $model->plus_paypal_id = $plan_plus->getId();

                if ($model && $model->save()) {
                    foreach ($post['Igualas']['igualasServicios'] as $key => $value) {
                        $igualaServicio = new \app\models\IgualasServicios();
                        $igualaServicio->fk_servicio = $value;
                        $igualaServicio->fk_iguala = $model->id;
                        $igualaServicio->save();
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'servicios' => $servicios,
        ]);
    }

    /**
     * Updates an existing Igualas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $iguala = new Igualas();
        $servicios = \app\models\Servicios::find()->where(['activo'=>true])->all();

        $post = Yii::$app->request->post();
        if ( $model->load($post) ){
            $iguala->load($post);
            if ($post['Igualas']['igualasServicios']==null)
            {
                Yii::$app->getSession()->setFlash('danger','Debe agregar al menos un servicio en la iguala');
            }
            else{
                $model->nombre = $model->nombre.date('now');
                $model->visible = 0;
                $model->estado = 0;
                $model->save();

                $iguala_servicio = ArrayHelper::getColumn($model->igualasServicios,'fk_servicio');
                $iguala->slim = str_replace(',', '', $model->slim);
                $iguala->med = str_replace(',', '', $model->med);
                $iguala->plus = str_replace(',', '', $model->plus);

                try {
                    paypalDeletePlan($model->slim);
                    paypalDeletePlan($model->med);
                    paypalDeletePlan($model->plus);

                    $plan_slim = paypalCreatePlan($iguala->slim, $iguala->nombre, $iguala->nombre."-slim", "Month");
                    $plan_med = paypalCreatePlan($iguala->med, $iguala->nombre, $iguala->nombre."-med", "Month");
                    $plan_plus = paypalCreatePlan($iguala->plus, $iguala->nombre, $iguala->nombre."-plus", "Month");
                }catch(\Exception $e){
                    Yii::$app->getSession()->setFlash('danger',$e->getMessage());
                    return $this->render('update', [
                       'model' => $model,
                       'servicios' => $servicios,
                    ]);
                }
                $iguala->slim_paypal_id = $plan_slim->getId();
                $iguala->med_paypal_id = $plan_med->getId();
                $iguala->plus_paypal_id = $plan_plus->getId();


                if ($iguala->save()) {
                    foreach ($model->igualasServicios as $key => $value) {
                        if(!in_array($value->fk_servicio, $post['Igualas']['igualasServicios']))
                        {
                            $value->delete();
                        }
                        else{
                            unset($post['Igualas']['igualasServicios'][$key]);
                        }
                    }
                    foreach ($post['Igualas']['igualasServicios'] as $key => $value) {
                        $igualaServicio = new \app\models\IgualasServicios();
                        $igualaServicio->fk_servicio = $value;
                        $igualaServicio->fk_iguala = $iguala->id;
                        $igualaServicio->save();
                    }
                    return $this->redirect(['view', 'id' => $iguala->id]);
                }

            }
        }
        return $this->render('update', [
            'model' => $model,
            'servicios' => $servicios,
        ]);
    }

    /**
     * Deletes an existing Igualas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = \app\models\Igualas::find()->where(['id'=>$id])->one();
        try {
            paypalDeletePlan($model->slim_paypal_id);
            paypalDeletePlan($model->med_paypal_id);
            paypalDeletePlan($model->plus_paypal_id);
        }catch(\Exception $e){
            Yii::$app->getSession()->setFlash('danger',$e->getMessage());
            return $this->redirect(['index']);
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Lista todas las igualas disponibles.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new IgualasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Se buscan también los servicios
        $serviciosModel = new \app\models\ServiciosSearch(['activo'=>true]);
        $serviciosProvider = $serviciosModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'serviciosProvider' => $serviciosProvider,
        ]);
    }

    /**
     * Despliega el detalle de una iguala.
     * @param integer $id
     * @return mixed
     */
    public function actionDetail($id)
    {
        return $this->render('detail', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Suscribe el usuario a la iguala
     * @param integer $id
     * @param integer $plan
     * @return mixed
     */
    public function actionSubscribe($id,$plan, $plan_number)
    {
        $perfil = \app\models\PerfilUsuario::find()->where(['fk_usuario'=>Yii::$app->user->id])->one();
        if($perfil){
            $model = \app\models\IgualasUsers::find()->where(['fk_users_cliente'=>$perfil->id, 'estatus'=>'solicitado'])->one();
            // if (!$model){
            //     $model = new \app\models\IgualasUsers();//::find()->where(['fk_users_cliente'=>$perfil->id])->one();
            //     $model->fk_users_cliente = $perfil->id;
            // }
            // arriba lo que hice fue: para efectos de la lógica si tiene un estatus de un plan solicitado entonces se sobreescribe ese, de lo contrario si no tiene nada entonces crea un nuevo registro con estatos solicitado.
            if($model){
                $model->fk_iguala = $id;
            }
            else{
                $model = new \app\models\IgualasUsers();
                $model->fk_iguala = $id;
                $model->estatus = "solicitado";
                $model->fk_users_cliente = $perfil->id;
            }
            $this->setPlan($model,$plan_number);
            
            try {         
                $agreement = createSubscriptionStepOne($plan, $perfil->nombres . ' '. $perfil->apellidos);
            }catch(\Exception $e){
                Yii::$app->getSession()->setFlash('danger',$e->getMessage());
                return $this->redirect(['detail','id'=> $id ]);
            }
            $approvalUrl = $agreement->getApprovalLink();
            // json_decode($agreement, true);
            // echo $approvalUrl;
            // die();

            if($model->validate() && $model->save()){
                Yii::$app->session->setFlash('success', 'Se ha creado la contratación a la iguala '.$model->fkIguala->nombre . ' Por favor verifique con PayPal para confirmar y continuar.');
                return $this->render('subscriptionStepOne', [
                        'approvalUrl' => $approvalUrl,
                        'agreement' => $agreement,
                        'model' => \app\models\Igualas::find()->where(['id'=>$id])->one(),
                    ]);
            }
            else{
                $html = '<ul>';
                foreach ($model->getErrors() as $key => $value) {
                    $html .= '<li>'.$value.'</li>';
                }
                $html .= '</ul>';
                Yii::$app->session->setFlash('error', $html);
            }
        }
        else{
            Yii::$app->session->setFlash('error', 'No existe este perfil de usuario');
        }
        return $this->redirect(['detail','id'=> $id ]);
        
    }
    public function actionSubscriptionStepOne(){
        return $this->render('detail', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionProcessagreement($token){
        $perfil = \app\models\PerfilUsuario::find()->where(['fk_usuario'=>Yii::$app->user->id])->one();
        try {
            $agreement = createSubscriptionStepTwo($token);
        }catch(\Exception $e){
            // Yii::$app->getSession()->setFlash('danger',$e->getMessage());
            echo "<h3>Por favor, verifique su conexion a internet y Regarge la pagina con F5</h3>\n\n";
            echo "Acaba de ocurrir un error de conexion con PayPal:\n".$e->getMessage()."\n\n";
            die();
        }
        $plan_viejo = false;
        $agreement_viejo = false;
        $html_iguala_vieja = "";
        // $agreement = "ads";
        $igualas_user = \app\models\IgualasUsers::find()->where(['fk_users_cliente'=>$perfil->id, 'estatus'=>'solicitado'])->one();
        if ($agreement && $agreement->state == "Active" && $igualas_user){
            Yii::$app->session->setFlash('success', 'Se ha subscrito al plan correctamente');
            
            $igualas_user_viejo = \app\models\IgualasUsers::find()->where(['fk_users_cliente'=>$perfil->id, 'estatus'=>'concretado'])->one();
            // echo $igualas_user->id, $igualas_user_viejo->id;
            // die();
            if ($igualas_user_viejo){
                $plan_viejo = \app\models\Igualas::find()->where(['id'=>$igualas_user_viejo->fk_iguala])->one();
                try {
                    $agreement_viejo = paypalSuspendPlanToUser($igualas_user_viejo->subscription_id);
                }catch(\Exception $e){
                    Yii::$app->getSession()->setFlash('danger',$e->getMessage());
                    return $this->render('precessagreement', [
                        'agreement' => $agreement,
                        "html_iguala_vieja" => $html_iguala_vieja
                    ]);
                }
                // $igualas_user_viejo->delete();
                $igualas_user_viejo->estatus = "cancelado";
                $igualas_user_viejo->save();
            }
            $igualas_user->estatus="concretado";
            $igualas_user->subscription_id=$agreement->id;
            $igualas_user->save();
            $agreement->id;
        }
        else {
            $html_iguala_vieja = "Ya la iguala ha sido subscrita al usuario";
        }
        
        if ($plan_viejo && $agreement_viejo){
            $html_iguala_vieja.= "Plan anterior: ".$plan_viejo->nombre. "";
            if ($plan_viejo->slim == "1"){ 
                $html_iguala_vieja.=" - slim";
            } 
            if ($plan_viejo->med== "1"){ 
                $html_iguala_vieja.= " - med";
            } 
            if ($plan_viejo->plus== "1"){ 
                $html_iguala_vieja.= " - plus";
            }
        }
        return $this->render('precessagreement', [
            'agreement' => $agreement,
            "html_iguala_vieja" => $html_iguala_vieja
        ]);
    }
    public function setPlan($model,$plan_number){
        

        $model->slim = 0;
        $model->med = 0;
        $model->plus = 0;
        if($plan_number==1){
            $model->slim = 1;
        }
        else if($plan_number==2){
            $model->med = 1;
        }
        else if($plan_number==3){
            $model->plus = 1;
        }
        $model->save();
    }

    /**
    *   Funcion para permitir al usuario activar/desactivar perfiles
    *   @author Rodrigo Da Costa
    *   @date 23/10/2017
    */
    public function actionActivar($id)
    {
        $model = $this->findModel($id);
        if($model->estado)
        {
            $model->estado=0;
            Yii::$app->getSession()->setFlash('warning',"Se desactivó la iguala con éxito.");
        }
        else
        {
            $model->estado=1;
            Yii::$app->getSession()->setFlash('success',"Se activó la iguala con éxito.");
        }
        $model->save();
        return $this->redirect('index');
    }

    /**
     * Finds the Igualas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Igualas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Igualas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
