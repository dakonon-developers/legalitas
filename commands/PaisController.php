<?php
namespace app\commands;
use Yii;
use yii\console\Controller;

/**
*   Clase que incluye las nacionalidades
*   @author Ing Leonel P. Hernandez M.
*   @date 28/06/2017
*/
class PaisController extends Controller
{
    public function actionMigrate()
    {
        $sql = file_get_contents(Yii::getAlias('@app').'/commands/pais.sql');
        Yii::$app->db->createCommand($sql)->execute();
        echo "Se migro con exito";
    }

    public function actionTruncate()
    {
        Yii::$app->db->createCommand("DELETE FROM pais")->execute();
        Yii::$app->db->createCommand("ALTER TABLE pais auto_increment = 1")->execute();
        echo "Se vacio la tabla con exito";
    }
}