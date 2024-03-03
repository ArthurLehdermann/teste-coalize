<?php

namespace app\controllers;

use Exception;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\services\AuthService;
use yii\web\Response;

class AuthController extends Controller
{
    private $authService;

    /**
     * @param $id
     * @param $module
     * @param AuthService $authService
     * @param $config
     */
    public function __construct($id, $module, AuthService $authService, $config = [])
    {
        $this->authService = $authService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if ($action->id == 'login') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * @return Response
     */
    public function actionLogin()
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        try {
            $token = $this->authService->authenticate($username, $password);
            return $this->asJson(['token' => $token]);
        } catch (Exception $exception) {

            Yii::$app->response->statusCode = 400;

            $message = [
                'error' => $exception->getMessage(),
            ];

            return $this->asJson($message);
        }
    }
}
