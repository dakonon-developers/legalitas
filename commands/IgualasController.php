<?php
namespace app\commands;
use Yii;
use yii\console\Controller;
require  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets'.DIRECTORY_SEPARATOR.'paypalFunctions.php';

class IgualasController extends Controller
{
    public function actionMigrate()
    {
        $iguala = new \app\models\Igualas;
        $sql = file_get_contents(Yii::getAlias('@app').'/commands/igualas.sql');
        Yii::$app->db->createCommand($sql)->execute();
        echo "***Se migro con exito igualas***\n";

        $rows = (new \yii\db\Query())
            ->select(['nombre', 'slim', 'med', 'plus', 'id'])
            ->from('igualas')
            ->all();
        echo "creando plan en paypal...\n";
        foreach ($rows as $row) {
            echo "creando plan en paypal para ". $row['nombre']."...\n";

            $plan_slim = paypalCreatePlan($row['slim'], $row['nombre'], $row['nombre']."-slim", "Month");
            $plan_med = paypalCreatePlan($row['med'], $row['nombre'], $row['nombre']."-med", "Month");
            $plan_plus = paypalCreatePlan($row['plus'], $row['nombre'], $row['nombre']."plus", "Month");

            echo "Plan ". $row['nombre'] . " Creado en PayPal fino.\n";
            
            $iguala = $iguala->find()->where(['id'=>$row['id']])->one();
            echo "plan_slim: ". $plan_slim->getId() . "\n";
            $iguala->slim_paypal_id = $plan_slim->getId();
            echo "plan_med: ". $plan_med->getId() . "\n";
            $iguala->med_paypal_id = $plan_med->getId();
            $iguala->plus_paypal_id = $plan_plus->getId();
            echo "plan_plus: ". $plan_plus->getId() . "\n";
            $iguala->save();
            echo "guardado? -> ".$iguala->save()."\n";
            echo "Plan ". $row['nombre'] ." Id de PayPal guardada en base de datos exito\nsamente.\n\n";
        }


    }

    public function actionTruncate()
    {
        Yii::$app->db->createCommand("DELETE FROM igualas")->execute();
        Yii::$app->db->createCommand("ALTER TABLE igualas auto_increment = 1")->execute();
        echo "Se vacio la tabla igualas con exito\n";

    }
}