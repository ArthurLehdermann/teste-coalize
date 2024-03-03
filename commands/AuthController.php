<?php

namespace app\commands;

use app\services\AuthService;
use Yii;
use yii\base\Action;
use yii\console\Controller;
use yii\console\Exception;
use yii\console\ExitCode;

class AuthController extends Controller
{
    private $authService;

    public function __construct($id, $module, AuthService $authService, $config = [])
    {
        $this->authService = $authService;
        parent::__construct($id, $module, $config);
    }

    /**
     * This command authenticates a user with the provided username and password
     * @param string $username The user's username
     * @param string $password The user's password
     * @return int Exit code
     * @throws Exception if authentication fails
     */
    public function actionLogin($username, $password)
    {
        try {
            $token = $this->authService->authenticate($username, $password);
            echo Yii::t('app', 'Token: {token}', ['token' => $token]) . "\n";
            return ExitCode::OK;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * Returns the parameter aliases for the console command
     * @return array The parameter aliases
     */
    public function getParametersAliases()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password')
        ];
    }

    /**
     * Translates command-line parameters using aliases for a more user-friendly console experience.
     * @param $action
     * @param $params
     * @return array
     * @throws Exception
     */
    public function bindActionParams($action, $params)
    {
        try {
            return parent::bindActionParams($action, $params);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            $aliases = $this->getParametersAliases();
            $message = strtr($message, $aliases);
            throw new Exception($message);
        }
    }
}
