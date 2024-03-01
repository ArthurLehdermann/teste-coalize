<?php

namespace app\commands;

use app\models\User;
use Yii;
use Exception;
use yii\console\Controller;
use yii\console\ExitCode;

class CreateUserController extends Controller
{
    /**
     * This command creates a new user with the provided login, password, and name
     * @param string $username The user's username
     * @param string $password The user's password
     * @param string $name The user's name
     * @return int Exit code
     * @throws Exception
     */
    public function actionCreate($username, $password, $name)
    {
        $user = new User;
        $user->username = $username;
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

    public function getParametersAliases()
    {
        return [
            'username' => 'Nome de usuário',
            'password' => 'Senha',
            'name' => 'Nome'
        ];
    }

    public function bindActionParams($action, $params)
    {
        try {
            return parent::bindActionParams($action, $params);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $aliases = $this->getParametersAliases();
            $message = strtr($message, $aliases);
            throw new \yii\console\Exception($message);
        }
    }
}
