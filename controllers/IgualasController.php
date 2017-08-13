<?php

namespace app\controllers;

use Yii;
use app\models\Igualas;
use app\models\IgualasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets'.DIRECTORY_SEPARATOR.'stripe.php';

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
        if ( $model->load(Yii::$app->request->post()) ){
            $model->slim = str_replace(',', '', $model->slim);
            $model->med = str_replace(',', '', $model->med);
            $model->plus = str_replace(',', '', $model->plus);
            $plan_slim = stripeCreatePlan($model->slim, $model->nombre."-slim", $model->nombre."-slim");
            $plan_med = stripeCreatePlan($model->med, $model->nombre."-med", $model->nombre."-med");
            $plan_plus = stripeCreatePlan($model->plus, $model->nombre."-plus", $model->nombre."-plus");
            $model->slim_stripe = $plan_slim->id;
            $model->med_stripe = $plan_med->id;
            $model->plus_stripe = $plan_plus->id;

            if ($model && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('create', [
                   'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
        if ( $model->load(Yii::$app->request->post()) ){
            $iguala = $this->findModel($id);
            print_r ($iguala);
            $model->slim = str_replace(',', '', $model->slim);
            $model->med = str_replace(',', '', $model->med);
            $model->plus = str_replace(',', '', $model->plus);
            if ($model->slim != $iguala->slim){
                stripeUpdatePlan($model->slim_stripe, $model->slim);
            }
            if ($model->med != $iguala->med){
                stripeUpdatePlan($model->med_stripe, $model->med);
            }
            if ($model->plus != $iguala->plus){
                stripeUpdatePlan($model->plus_stripe, $model->plus);
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Igualas model.
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
