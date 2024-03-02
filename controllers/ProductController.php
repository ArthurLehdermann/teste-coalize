<?php

namespace app\controllers;

use Yii;
use app\services\ProductService;

class ProductController extends BaseController
{
    private $productService;

    public function __construct($id, $module, ProductService $productService, $config = [])
    {
        $this->productService = $productService;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['create', 'update', 'delete'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $conditions = Yii::$app->request->get();
        unset($conditions['p']);

        $data = $this->productService->list($conditions);

        return $this->success($data);
    }

    public function actionCreate()
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        $product = $this->productService->create($data);
        if ($product->hasErrors()) {
            return $this->error($product->getErrors());
        }

        return $this->ok($product);
    }

    public function actionRead($id)
    {
        try {
            $product = $this->productService->read($id);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->statusCode);
        }

        return $this->success($product);
    }

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

        return $this->success('Produto deletado com sucesso');
    }
}
