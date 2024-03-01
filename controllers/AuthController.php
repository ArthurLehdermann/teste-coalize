<?php

namespace app\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\services\AuthService;

class AuthController extends Controller
{
    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if ($action->id == 'login') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionLogin()
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);
        $username = $data['username'];
        $password = $data['password'];

        $service = new AuthService;

        try {
            $token = $service->authenticate($username, $password);
            return $this->asJson(['token' => $token]);
        } catch (\Exception $exception) {
            return $this->asJson(['error' => $exception->getMessage()], 400);
        }
    }
}
