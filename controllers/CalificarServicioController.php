<?php

namespace app\controllers;

use Yii;
use app\models\CalificarServicio;
use app\models\CalificarServicioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CalificarServicioController implements the CRUD actions for CalificarServicio model.
 */
class CalificarServicioController extends Controller
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
        ];
    }

    /**
     * Lists all CalificarServicio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CalificarServicioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CalificarServicio model.
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
     * Creates a new CalificarServicio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($consulta)
    {
        $model = new CalificarServicio();
        $calificacion = new \app\models\Calificacion();

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            // Se califica el servicio
            if(!CalificarServicio::find()->where(['fk_consulta'=>$consulta])->one())
            {
                $model->fk_consulta = $consulta;
                //$model->save();
                // Se guardan las recomendaciones
                if($model->nos_recomendaria){
                    foreach ($post['Recomendaciones']['correo'] as $key => $value) {
                        $recomendaciones = new \app\models\Recomendaciones();
                        $recomendaciones->correo = $value;
                        $recomendaciones->telefono = $post['Recomendaciones']['telefono'][$key];
                        //$recomendaciones->fk_calificacion_servicio = $model->id;
                        //$recomendaciones->save();
                    }
                }
                Yii::$app->session->addFlash('success', 'Se calificó el servicio con éxito.');
            }
            else{
                Yii::$app->session->setFlash('error', 'Ya calificó este servicio.');
            }
            // Se califica el abogado
            if(!\app\models\Calificacion::find()->where(['fk_consulta'=>$consulta])->one())
            {
                $calificacion->calificacion = $post['star_rating'] ? $post['star_rating']:0;
                $calificacion->fk_consulta = $consulta;
                //$calificacion->save();
                Yii::$app->session->addFlash('success', 'Se calificó el abogado con éxito.');
            }
            else{
                Yii::$app->session->setFlash('error', 'Ya calificó este abogado.');
            }
            return $this->redirect(['/respuesta-consulta', 'consulta' => $consulta]);
            //print_r($post);
        } /*else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
    }

    /**
     * Updates an existing CalificarServicio model.
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
     * Deletes an existing CalificarServicio model.
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
     * Finds the CalificarServicio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CalificarServicio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CalificarServicio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
