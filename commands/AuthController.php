<?php

namespace app\commands;

use app\services\AuthService;
use yii\console\Controller;
use yii\console\ExitCode;

class AuthController extends Controller
{
    /**
     * This command authenticates a user with the provided username and password
     * @param string $username The user's username
     * @param string $password The user's password
     * @return int Exit code
     * @throws \Exception
     */
    public function actionLogin($username, $password)
    {
        $service = new AuthService;

        try {
            $token = $service->authenticate($username, $password);
            echo "Token: $token\n";
            return ExitCode::OK;
        } catch (\Exception $exception) {
            echo "Error: " . $exception->getMessage() . "\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

    public function getParametersAliases()
    {
        return [
            'username' => 'Nome de usuário',
            'password' => 'Senha'
        ];
    }

    public function bindActionParams($action, $params)
    {
        try {
            return parent::bindActionParams($action, $params);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            $aliases = $this->getParametersAliases();
            $message = strtr($message, $aliases);
            throw new \yii\console\Exception($message);
        }
    }
}
