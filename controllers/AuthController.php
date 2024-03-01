<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\services\AuthService;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $service = new AuthService;

        try {
            $token = $service->authenticate($username, $password);
            return $this->asJson(['token' => $token]);
        } catch (\Exception $exception) {
            return $this->asJson(['error' => $exception->getMessage()], 400);
        }
    }
}
