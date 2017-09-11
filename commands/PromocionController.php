<?php
namespace app\commands;
use Yii;
use yii\console\Controller;

/**
*   Clase que inicia las promociones
*   @author Rodrigo Boet
*   @date 13/08/2017
*/
class PromocionController extends Controller
{
    public function actionInit()
    {
        $promocion = \app\models\Promociones::findOne(1);
        if(!$promocion){
            $promocion = new \app\models\Promociones();
            $promocion->slim = 5;
            $promocion->med = 10;
            $promocion->plus = 20;
            $promocion->save();
        }
        foreach (\app\models\Servicios::find()->all() as $key => $servicio) {
            $serv_prom = new \app\models\ServicioPromocion();
            $serv_prom->fk_servicio = $servicio->id; 
            $serv_prom->fk_promocion = $promocion->id;
            $serv_prom->save();
        }
        echo "Se establecieron las promociones con exito\n";
    }

    /*public function actionTruncate()
    {
        Yii::$app->db->createCommand("DELETE FROM materia")->execute();
        Yii::$app->db->createCommand("ALTER TABLE materia auto_increment = 1")->execute();
        Yii::$app->db->createCommand("ALTER TABLE servicios auto_increment = 1")->execute();
        echo "Se vacio la tabla con exito";
    }*/
}