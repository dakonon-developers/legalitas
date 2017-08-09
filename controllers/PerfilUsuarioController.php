<?php

namespace app\controllers;

use Yii;
use app\models\PerfilUsuario;
use app\models\PerfilUsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                        'actions' => ['create','view'],
                        'allow' => true,
                        'roles' => ['Usuario'],
                    ],
                    [
                        'actions' => ['index','activar'],
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

    /**
     * Updates an existing PerfilUsuario model.
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
}
