<?php

namespace app\controllers;

use yii\web\Controller;
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
}
