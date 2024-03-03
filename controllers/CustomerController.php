<?php

namespace app\controllers;

use Yii;
use app\services\CustomerService;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class CustomerController extends BaseController
{
    private $customerService;

    /**
     * @param $id
     * @param $module
     * @param CustomerService $customerService
     * @param $config
     */
    public function __construct($id, $module, CustomerService $customerService, $config = [])
    {
        $this->customerService = $customerService;
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

        $data = $this->customerService->list($conditions);

        return $this->success($data);
    }

    /**
     * @return Response
     */
    public function actionCreate()
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        $customer = $this->customerService->create($data);
        if ($customer->hasErrors()) {
            return $this->error($customer->getErrors());
        }

        return $this->ok($customer);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionRead($id)
    {
        try {
            $customer = $this->customerService->read($id);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->statusCode);
        }

        return $this->success($customer);
    }

    /**
     * @param $id
     * @return Response
     */
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

    /**
     * @param $id
     * @return Response
     */
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

        return $this->success(Yii::t('app', 'Customer deleted successfully'));
    }
}
