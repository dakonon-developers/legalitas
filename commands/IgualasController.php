<?php
namespace app\commands;
use Yii;
use yii\console\Controller;

class IgualasController extends Controller
{
    public function actionMigrate()
    {
        $sql = file_get_contents(Yii::getAlias('@app').'/commands/igualas.sql');
        Yii::$app->db->createCommand($sql)->execute();
        echo "Se migro con exito igualas";
    }

    public function actionTruncate()
    {
        Yii::$app->db->createCommand("DELETE FROM igualas")->execute();
        Yii::$app->db->createCommand("ALTER TABLE igualas auto_increment = 1")->execute();
        echo "Se vacio la tabla igualas con exito";
    }
}