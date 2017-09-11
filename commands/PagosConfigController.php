<?php
namespace app\commands;
use Yii;
use yii\console\Controller;

/**
*   Clase que incluye las nacionalidades
*   @author Ing Leonel P. Hernandez M.
*   @date 28/06/2017
*/
class PagosConfigController extends Controller
{
    public function actionMigrate()
    {
        $sql = file_get_contents(Yii::getAlias('@app').'/commands/pagos.sql');
        Yii::$app->db->createCommand($sql)->execute();
        echo "Se migro con exito pagos_config\n";
    }

    public function actionTruncate()
    {
        Yii::$app->db->createCommand("DELETE FROM pagos_config")->execute();
        Yii::$app->db->createCommand("ALTER TABLE pagos_config auto_increment = 1")->execute();
        echo "Se vacio la tabla pagos_config con exito\n";
    }
}