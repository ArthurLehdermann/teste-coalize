<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class BaseController extends Controller
{
    public function init()
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    protected function ok($data, $code = 201)
    {
        return $this->success($data, $code);
    }

    protected function success($data, $code = 200)
    {
        Yii::$app->response->statusCode = $code;

        if (is_string($data)) {
            $data = [
                'message' => $data,
            ];
        }

        return $this->asJson($data);
    }

    protected function error($message, $code = 400)
    {
        Yii::$app->response->statusCode = $code;

        if (is_string($message)) {
            $message = [
                'message' => $message,
            ];
        }

        return $this->asJson($message);
    }
}
