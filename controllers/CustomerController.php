<?php

namespace app\controllers;

use Yii;
use app\services\CustomerService;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct($id, $module, CustomerService $customerService, $config = [])
    {
        $this->customerService = $customerService;
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

        $data = $this->customerService->list($conditions);

        return $this->success($data);
    }

    public function actionCreate()
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        $customer = $this->customerService->create($data);
        if ($customer->hasErrors()) {
            return $this->error($customer->getErrors());
        }

        return $this->ok($customer);
    }

    public function actionRead($id)
    {
        try {
            $customer = $this->customerService->read($id);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->statusCode);
        }

        return $this->success($customer);
    }

    public function actionUpdate($id)
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        try {
            $customer = $this->customerService->update($id, $data);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->statusCode);
        }

        if ($customer->hasErrors()) {
            return $this->error($customer->getErrors());
        }

        return $this->success($customer);
    }

    public function actionDelete($id)
    {
        try {
            $customer = $this->customerService->delete($id);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->statusCode);
        }

        if ($customer->hasErrors()) {
            return $this->error($customer->getErrors());
        }

        return $this->success('Cliente deletado com sucesso');
    }
}
