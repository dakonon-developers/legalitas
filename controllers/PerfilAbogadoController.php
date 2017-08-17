<?php

namespace app\controllers;

use Yii;
use app\models\PerfilAbogado;
use app\models\PerfilAbogadoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PerfilAbogadoController implements the CRUD actions for PerfilAbogado model.
 */
class PerfilAbogadoController extends Controller
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
                        'actions' => ['create','view','update'],
                        'allow' => true,
                        'roles' => ['Abogado Interno','Abogado Externo'],
                    ],
                    [
                        'actions' => ['index','activar','view'],
                        'allow' => true,
                        'roles' => ['Admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PerfilAbogado models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PerfilAbogadoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PerfilAbogado model.
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
     * Creates a new PerfilAbogado model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PerfilAbogado();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PerfilAbogado model.
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
     * Deletes an existing PerfilAbogado model.
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
    *   Funcion para permitir al usuario activar/desactivar perfil de abogado
    *   @author Rodrigo Da Costa
    *   @date 16/07/2017
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
            $authorRole = $model->tipo_abogado ? $auth->getRole('Abogado Interno'):$auth->getRole('Abogado Externo');
            $auth->assign($authorRole, $model->fk_usuario);
            Yii::$app->getSession()->setFlash('success',"Se activó el usuario.");
        }
        $model->save();
        return $this->redirect('index');
    }

    /**
     * Finds the PerfilAbogado model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PerfilAbogado the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PerfilAbogado::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
