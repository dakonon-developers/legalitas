<?php

namespace app\controllers;

use Yii;
use app\models\Dudas;
use app\models\DudasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DudasController implements the CRUD actions for Dudas model.
 */
class DudasController extends Controller
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
                        'actions' => ['index','create'],
                        'allow' => true,
                        'roles' => ['Usuario','Abogado Interno','Abogado Externo'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Dudas models.
     * @return mixed
     */
    public function actionIndex($consulta)
    {
        $model = new Dudas();

        if(Yii::$app->user->can('Usuario')){
            $perfil = \app\models\PerfilUsuario::find()->where(['fk_usuario'=>Yii::$app->user->id])->one()->id;
        }
        else{
            $perfil = \app\models\PerfilAbogado::find()->where(['fk_usuario'=>Yii::$app->user->id])->one()->id;   
        }
        if(\app\models\Consulta::find()->where('id='.$consulta.' AND (fk_cliente='.$perfil.' OR 
            fk_abogado_asignado='.$perfil.')')->one())
        {
            $searchModel = new DudasSearch(['fk_consulta'=>$consulta]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $consulta_finalizo = \app\models\Consulta::findOne($consulta)->finalizado;

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'consulta' => $consulta,
                'model' => $model,
                'finalizo' => $consulta_finalizo,
            ]);
        }
        else{
            throw new \yii\web\ForbiddenHttpException("No tiene permitido ejecutar esta acción.");
        }
    }

    /**
     * Displays a single Dudas model.
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
     * Creates a new Dudas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($consulta)
    {
        $model = new Dudas();
        $consulta_finalizo = \app\models\Consulta::findOne($consulta)->finalizado;

        if ($model->load(Yii::$app->request->post()) and !$consulta_finalizo) {
            $model->fk_user = Yii::$app->user->id;
            $model->fk_consulta = $consulta;
            $model->save();
            Yii::$app->session->setFlash('success', 'Se publicó con éxito.');
            return $this->redirect(['index', 'consulta' => $consulta]);
        } /*else {
            return $this->render('create', [
                'model' => $model,
                'consulta' => $consulta,
            ]);
        }*/
    }

    /**
     * Updates an existing Dudas model.
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
     * Deletes an existing Dudas model.
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
     * Finds the Dudas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dudas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dudas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
