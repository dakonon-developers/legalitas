<?php
namespace app\commands;
use Yii;
use yii\console\Controller;
use app\models\User;
use app\models\Perfil;
use app\forms\SignupForm;

/**
*   Clase para crear un admin
*   @author Rodrigo Boet
*   @date 26/10/2016
*/
class AdminController extends Controller
{
    public $password;

    public function actionInit()
    {
        if(!empty($this->password))
        {
            $model = new SignupForm();
            $model->username = 'Admin';
            $model->email = 'admin@app.com';
            $model->password = $this->password;
            if($model->validate())
            {
                $user = new User();
                $user->username = 'Admin';
                $user->email = "admin@app.com";
                $user->setPassword($model->password);
                $user->generateAuthKey();
                $user->save();
                //Se crea el perfil
                /*$perfil = new Perfil();
                $perfil->telefono = '000-0000000';
                $perfil->genero = 'M';
                $perfil->edad = 1;
                $perfil->fecha_nacimiento = date('Y-m-d');
                $perfil->fk_user = $user->id;
                $perfil->fk_pais = 66;
                $perfil->save();
                //Se asigna el rol del usuario
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole('ADMIN');
                $auth->assign($authorRole, $user->id);
                echo "Se creo el admin con exito";*/
            }
            else
            {
                echo "Ocurrio un error";
                print_r($model->getErrors());
            }
        }
        else
        {
            echo "Debe pasar el parametro password";
        }
    }

    public function actionDrop()
    {
        if(User::findByUsername('Admin'))
        {
            $admin = User::findByUsername('Admin');
            $admin->delete();
            echo "Se elimino con exito el usuario admin";
        }
        else
        {
            echo "No se encontro el usuario Admin";
        }        
    }

    public function actionHelp()
    {
        echo "Ingrese: admin/init --password=\"su contrasena aqui\"";
    }

    public function options($actionID)
    {
        // $actionId might be used in subclasses to provide options specific to action id
        return ['password'];
    }
}