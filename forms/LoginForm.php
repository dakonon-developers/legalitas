<?php

namespace app\forms;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user_username = false;
    private $_user_email = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user_un = $this->getUser();
            $user_em = $this->getMail();

            if ((!$user_un || !$user_un->validatePassword($this->password)) and ((!$user_em || !$user_em->validatePassword($this->password)))) {
                $this->addError($attribute, 'Nombre incorrecto o contraseña.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser() == True ? $this->getUser():$this->getMail();
            return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user_username === false) {
            $this->_user_username = \app\models\User::findByUsername($this->username);
        }

        return $this->_user_username;
    }

    /**
     * Método para obtener un usuario por email
     * @author Rodrigo Boet
     * @date 10/09/2016
     * @return Regresa el usuario
    */
    public function getMail()
    {
        if ($this->_user_email === false) {
            $this->_user_email = \app\models\User::findByEmail($this->username);
        }

        return $this->_user_email;
    }
}
