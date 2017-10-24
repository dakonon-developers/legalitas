<?php

namespace app\forms;

use Yii;
use yii\base\Model;

/**
 * Formulario para enviar correos
 */
class SendMailsForm extends Model
{
    public $email;
    public $subject;
    public $body;
    public $tipo;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            [['email','tipo'], 'string'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Correos',
            'body' => 'Contenido del Correo',
            'subject' => 'Motivo',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function sendMails($emails)
    {
        if ($this->validate()) {
            try{
                
                Yii::$app->mailer->compose()
                    ->setFrom([\Yii::$app->params['adminEmail'] => 'Administrador LegalitasRd'])
                    ->setTo($emails)
                    ->setSubject($this->subject)
                    ->setTextBody($this->body)
                    ->send();
                return true;
                
            }catch(\Exception $e){

                return false;
            }
            
        }

    }
}