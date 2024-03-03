<?php

namespace app\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Controller;
use yii\web\Response;

class BaseController extends Controller
{
    /**
     * @return void
     */
    public function init()
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    /**
     * @param $data
     * @param $code
     * @return Response
     */
    protected function ok($data, $code = 201)
    {
        return $this->success($data, $code);
    }

    /**
     * @param $data
     * @param $code
     * @return Response
     */
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

    /**
     * @param $message
     * @param $code
     * @return Response
     */
    protected function error($message, $code = 400)
    {
        Yii::$app->response->statusCode = $code;

        if (is_string($message)) {
            $message = [
                'error' => $message,
            ];
        }

        return $this->asJson($message);
    }
}
