<?php

namespace app\components\helpers;

use app\services\AuthService;
use Yii;
use yii\web\Response;

class HttpBearerAuth extends \yii\filters\auth\HttpBearerAuth
{
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        try {
            $authHeader = $request->getHeaders()->get('Authorization');
            preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches);

            $authService = new AuthService;
            $authService->validateToken($matches[1]);

            return $user->loginByAccessToken($matches[1], get_class($this));
        } catch (\Exception $exception) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->response->data = ['error' => $exception->getMessage()];
            Yii::$app->response->statusCode = 401;
            Yii::$app->end();
        }
    }
}