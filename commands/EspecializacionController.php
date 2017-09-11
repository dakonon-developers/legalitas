<?php
namespace app\commands;
use Yii;
use yii\console\Controller;

/**
*   Clase que incluye las nacionalidades
*   @author Ing Leonel P. Hernandez M.
*   @date 28/06/2017
*/
class EspecializacionController extends Controller
{
    public function actionMigrate()
    {
        $sql = file_get_contents(Yii::getAlias('@app').'/commands/especializacion.sql');
        Yii::$app->db->createCommand($sql)->execute();
        echo "Se migro con exito\n";
    }

    public function actionTruncate()
    {
        Yii::$app->db->createCommand("DELETE FROM especializacion")->execute();
        Yii::$app->db->createCommand("ALTER TABLE especializacion auto_increment = 1")->execute();
        echo "Se vacio la tabla con exito\n";
    }
}