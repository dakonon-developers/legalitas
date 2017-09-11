<?php
namespace app\commands;
use Yii;
use yii\console\Controller;

/**
*   Clase que incluye los roles de la aplicación en BD
*   @author Rodrigo Boet
*   @date 10/09/2016
*/
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        // se crea el permiso del admin
        $admin = $auth->createRole('Admin');
        $admin->description = 'Es el administrador del sitio';
        $auth->add($admin);
        // se crea el permiso de abogado interno
        $abogado_interno = $auth->createRole('Abogado Interno');
        $abogado_interno->description = 'Es rol correspondiente al abogado interno';
        $auth->add($abogado_interno);
        // se crea el permiso de abogado externo
        $abogado_externo = $auth->createRole('Abogado Externo');
        $abogado_externo->description = 'Es rol correspondiente al abogado externo';
        $auth->add($abogado_externo);
        // se crea el permiso del usuario
        $usuario = $auth->createRole('Usuario');
        $usuario->description = 'Es el rol del usuario común';
        $auth->add($usuario);
        // se crea el permiso del invitado
        $invitado = $auth->createRole('Invitado');
        $invitado->description = 'Es el rol de invitado';
        $auth->add($invitado);
        echo "Se crearon los roles con exito\n";
    }
}