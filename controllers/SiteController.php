<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * Displays homepage
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Redirect to about page
     *
     * @return Response
     */
    public function actionAbout()
    {
        return $this->redirect('https://arthur.lehdermann.com/');
    }

    /**
     * Download Insomnia_2024-03-03.json file
     *
     * @throws NotFoundHttpException
     */
    public function actionRotas()
    {
        $filePath = Yii::getAlias('@app') . '/Insomnia_2024-03-03.json';
        if (file_exists($filePath)) {
            return Yii::$app->response->sendFile($filePath);
        } else {
            throw new \yii\web\NotFoundHttpException('File not found.');
        }
    }
}
