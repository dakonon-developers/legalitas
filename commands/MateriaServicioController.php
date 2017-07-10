<?php
namespace app\commands;
use Yii;
use yii\console\Controller;

/**
*   Clase que incluye las Materias y servicios
*   @author Rodrigo Boet
*   @date 09/07/2017
*/
class MateriaServicioController extends Controller
{
    public function actionMigrate()
    {
        $sql = file_get_contents(Yii::getAlias('@app').'/commands/materia.sql');
        Yii::$app->db->createCommand($sql)->execute();
        $sql = file_get_contents(Yii::getAlias('@app').'/commands/servicios.sql');
        Yii::$app->db->createCommand($sql)->execute();
        echo "Se migro con exito";
    }

    public function actionTruncate()
    {
        Yii::$app->db->createCommand("DELETE FROM materia")->execute();
        Yii::$app->db->createCommand("ALTER TABLE materia auto_increment = 1")->execute();
        Yii::$app->db->createCommand("ALTER TABLE servicios auto_increment = 1")->execute();
        echo "Se vacio la tabla con exito";
    }
}