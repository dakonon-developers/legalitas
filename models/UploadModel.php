<?php

namespace app\models;

use Yii;


class UploadModel
{
	/**
     * Función para cargar los archivos y asignar la ruta a un párametro del modelo
     * @param $file Recibe la instancia del archivo cargado
     * @param $unique_string Recibe el string único
     */
    public function Upload($file,$unique_string)
    {
        if($file){
            $ext = pathinfo($file->name,PATHINFO_EXTENSION);
            $name = $unique_string.Yii::$app->security->generateRandomString();
            $name .= '.'.$ext;
            $file->saveAs(Yii::getAlias('@webroot'). '/uploads/' . $name);
            return '/uploads/' . $name;
        }
        return '';
    }
}