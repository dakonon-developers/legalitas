<?php

namespace app\controllers;

use Yii;
use app\models\RespuestaConsulta;
use app\models\RespuestaConsultaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RespuestaConsultaController implements the CRUD actions for RespuestaConsulta model.
 */
class RespuestaConsultaController extends Controller
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['Usuario','Abogado Interno','Abogado Externo'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['Abogado Interno','Abogado Externo'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all RespuestaConsulta models.
     * @return mixed
     */
    public function actionIndex($consulta)
    {
        if(Yii::$app->user->can('Usuario')){
            $perfil = \app\models\PerfilUsuario::find()->where(['fk_usuario'=>Yii::$app->user->id])->one()->id;
        }
        else{
            $perfil = \app\models\PerfilAbogado::find()->where(['fk_usuario'=>Yii::$app->user->id])->one()->id;   
        }
        if(\app\models\Consulta::find()->where('id='.$consulta.' AND (fk_cliente='.$perfil.' OR 
            fk_abogado_asignado='.$perfil.')')->one())
        {
            $searchModel = new RespuestaConsultaSearch(['fk_consulta'=>$consulta]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $model = new RespuestaConsulta();

            $consulta_finalizo = \app\models\Consulta::findOne($consulta)->finalizado;

            // Se instancia el servicio y las recomendaciones
            $servicio = new \app\models\CalificarServicio();
            $recomendaciones = new \app\models\Recomendaciones();
            // Se instancia la calificacion
            $calificacion = \app\models\Calificacion::find()->where(['fk_consulta'=>$consulta])->one();

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'consulta' => $consulta,
                'model' => $model,
                'finalizo' => $consulta_finalizo,
                'servicio' => $servicio,
                'recomendaciones' => $recomendaciones,
                'calificacion' => $calificacion,
            ]);
        }
        else{
            throw new \yii\web\ForbiddenHttpException("No tiene permitido ejecutar esta acción.");
        }
    }

    /**
     * Displays a single RespuestaConsulta model.
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
     * Creates a new RespuestaConsulta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($consulta)
    {
        $model = new RespuestaConsulta();
        $consulta_finalizo = \app\models\Consulta::findOne($consulta)->finalizado;

        if ($model->load(Yii::$app->request->post()) and (!$consulta_finalizo or $consulta_finalizo==null)) {
            // Se guarda la respuesta
            $perfil = \app\models\PerfilAbogado::find()->where(['fk_usuario'=>Yii::$app->user->id])->one()->id; 
            $model->fk_consulta = $consulta;
            $model->fk_abogado = $perfil;
            $model->save();
            // Se actualiza la consulta
            $consulta_guardar = \app\models\Consulta::findOne($consulta);
            $consulta_guardar->finalizado = True;
            $consulta_guardar->fecha_fin = date('Y-m-d');
            $consulta_guardar->save();
            Yii::$app->session->setFlash('success', 'Se publicó la respuesta con éxito.');
            return $this->redirect(['index', 'consulta' => $consulta]);
        }
         /*else {
            return $this->render('create', [
                'model' => $model,
                'consulta' => $consulta,
            ]);
        }*/
    }

    /**
     * Updates an existing RespuestaConsulta model.
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
     * Deletes an existing RespuestaConsulta model.
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
     * Finds the RespuestaConsulta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RespuestaConsulta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RespuestaConsulta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
