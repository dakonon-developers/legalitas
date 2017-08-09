<?php

namespace app\controllers;

use Yii;
use app\models\Calificacion;
use app\models\CalificacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CalificacionController implements the CRUD actions for Calificacion model.
 */
class CalificacionController extends Controller
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
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['Admin'],
                    ],
                    [
                        'actions' => ['micalificacion'],
                        'allow' => true,
                        'roles' => ['Abogado Interno','Abogado Externo'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Calificacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CalificacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Calificacion of lawyer.
     * @return mixed
     */
    public function actionMicalificacion()
    {
        $perfil = \app\models\PerfilAbogado::find()->where(['fk_usuario'=>Yii::$app->user->id])->one();
        $searchModel = new CalificacionSearch(['abogado'=> $perfil->id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('micalificacion', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Calificacion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $recomendaciones = $model->fkConsulta->calificarServicio->recomendaciones;
        return $this->render('view', [
            'model' => $model,
            'recomendaciones' => $recomendaciones,
        ]);
    }

    /**
     * Creates a new Calificacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Calificacion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Calificacion model.
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
     * Deletes an existing Calificacion model.
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
     * Finds the Calificacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calificacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calificacion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
