<?php

namespace app\commands;

use yii\console\Controller;
use app\services\AuthService;

class AuthController extends Controller
{
    public function actionLogin($username, $password)
    {
        $service = new AuthService;

        try {
            $token = $service->authenticate($username, $password);
            echo "Token: $token\n";
        } catch (\Exception $exception) {
            echo "Error: " . $exception->getMessage() . "\n";
        }
    }
}
