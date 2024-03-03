<?php

namespace app\commands;

use app\services\UserService;
use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\console\ExitCode;

class UserController extends Controller
{
    private $userService;

    /**
     * @param $id
     * @param $module
     * @param UserService $userService
     * @param $config
     */
    public function __construct($id, $module, UserService $userService, $config = [])
    {
        $this->userService = $userService;
        parent::__construct($id, $module, $config);
    }

    /**
     * This command creates a new user with the provided login, password, and name
     * @param string $username The user's username
     * @param string $password The user's password
     * @param string $name The user's name
     * @return int Exit code
     * @throws Exception if user creation fails
     */
    public function actionCreate($username, $password, $name)
    {
        $user = $this->userService->create($username, $password, $name);

        if (!$user->validate()) {
            throw new Exception(implode(', ', $user->getFirstErrors()));
        }

        if ($user->hasErrors()) {
            throw new Exception(implode(', ', $user->getFirstErrors()));
        }

        echo Yii::t('app', 'User "{name}" successfully created', ['name' => $user->name]) . "\n";

        return ExitCode::OK;
    }

    /**
     * @return array
     */
    public function getParametersAliases()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'name' => Yii::t('app', 'Name')
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