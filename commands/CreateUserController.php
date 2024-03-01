<?php

namespace app\commands;

use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;

class CreateUserController extends Controller
{
    /**
     * This command creates a new user with the provided login, password, and name.
     * @param string $login The user's login.
     * @param string $password The user's password.
     * @param string $name The user's name.
     * @return int Exit code
     * @throws Exception
     */
    public function actionCreate($login, $password, $name)
    {
        $user = new User;
        $user->username = $login;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($password);
        $user->name = $name;

        if ($user->save()) {
            echo "Usuário \"$name\" criado com sucesso.\n";
            return ExitCode::OK;
        } else {
            echo "Erro ao criar usuário: " . implode(', ', $user->getFirstErrors()) . "\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}
