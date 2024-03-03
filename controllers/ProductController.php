<?php

namespace app\controllers;

use Yii;
use app\services\ProductService;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class ProductController extends BaseController
{
    private $productService;

    /**
     * @param $id
     * @param $module
     * @param ProductService $productService
     * @param $config
     */
    public function __construct($id, $module, ProductService $productService, $config = [])
    {
        $this->productService = $productService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (in_array($action->id, ['create', 'update', 'delete'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * @return Response
     */
    public function actionIndex()
    {
        $conditions = Yii::$app->request->get();
        unset($conditions['p']);

        $data = $this->productService->list($conditions);

        return $this->success($data);
    }

    /**
     * @return Response
     */
    public function actionCreate()
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        $product = $this->productService->create($data);
        if ($product->hasErrors()) {
            return $this->error($product->getErrors());
        }

        return $this->ok($product);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionRead($id)
    {
        try {
            $product = $this->productService->read($id);
            $product = $product->toArray([], ['customer']);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->statusCode);
        }

        return $this->success($product);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionUpdate($id)
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        try {
            $product = $this->productService->update($id, $data);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->statusCode);
        }

        if ($product->hasErrors()) {
            return $this->error($product->getErrors());
        }

        return $this->success($product);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDelete($id)
    {
        try {
            $product = $this->productService->delete($id);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->statusCode);
        }

        if ($product->hasErrors()) {
            return $this->error($product->getErrors());
        }

        return $this->success(Yii::t('app', 'Product deleted successfully'));
    }
}
