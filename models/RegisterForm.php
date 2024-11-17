<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\VarDumper;

class RegisterForm extends Model
{
    public $name;
    public $password;
    public $email;
    public $password_repeat;

    public function rules()
    {
        return [
            [['name', 'password', 'email', 'password_repeat'], 'required'],
            ['email', 'email'],
            ['user_name', 'string', 'min' => 3, 'max' => 150],
            [['password', 'password_repeat'], 'string', 'min' => 8, 'max' => 255],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function register()
    {
        $user = new User();
        $user->user_name = $this->name;
        $user->email = $this->email;
        $user->password = \Yii::$app->security->generatePasswordHash($this->password);
        $user->access_token = \Yii::$app->security->generateRandomString();
        $user->auth_key = \Yii::$app->security->generateRandomString();

        if($user->save()){
            $auth = \Yii::$app->authManager;
            $customerRole = $auth->getRole('customer');
            $auth->assign($customerRole, $user->getId());
            return true;
        }
        \Yii::error('user not registered '.VarDumper::dumpAsString($user->errors));
        return false;
    }
}