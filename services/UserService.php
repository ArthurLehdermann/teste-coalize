<?php

namespace app\services;

use app\models\User;
use Yii;

class UserService
{
    public function create($username, $password, $name)
    {
        $user = new User;
        $user->username = $username;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($password);
        $user->name = $name;
        $user->save();

        return $user;
    }
}