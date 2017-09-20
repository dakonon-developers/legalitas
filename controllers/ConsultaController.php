<?php

namespace app\controllers;

use Yii;
use app\models\Consulta;
use app\models\ConsultaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                        'actions' => ['create','view'],
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
    public function actionCreate($categoria)
    {
        $model = new Consulta();

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
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
