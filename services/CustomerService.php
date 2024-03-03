<?php

namespace app\services;

use app\models\Customer;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class CustomerService extends BaseService
{
    public function create($data)
    {
        $customer = new Customer;
        $customer->attributes = $data;
        $customer->save();

        return $customer;
    }

    public function read($id)
    {
        $customer = Customer::findOne($id);
        if (!$customer) {
            throw new NotFoundHttpException(Yii::t('app', 'Customer not found'));
        }

        return $customer;
    }

    public function update($id, $data)
    {
        $customer = Customer::findOne($id);
        if (!$customer) {
            throw new NotFoundHttpException(Yii::t('app', 'Customer not found'));
        }

        $customer->attributes = $data;
        $customer->save();

        return $customer;
    }

    public function delete($id)
    {
        $customer = Customer::findOne($id);
        if (!$customer) {
            throw new NotFoundHttpException(Yii::t('app', 'Customer not found'));
        }

        $customer->delete();

        return $customer;
    }

    public function list($conditions = [])
    {
        $page = (int) ($conditions['page'] ?? 1);
        unset($conditions['page']);

        $pageSize = (int) ($conditions['pageSize'] ?? 10);
        unset($conditions['pageSize']);

        $query = Customer::find()->where($conditions);

        $totalCount = (int) $query->count();

        $pagination = new Pagination([
            'totalCount' => $totalCount,
        ]);
        $pagination->setPage($page -1); // Yii2's Pagination page index is 0-based
        $pagination->setPageSize($pageSize);

        $results = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return [
            '_links' => $this->getPaginationLinks($pagination),
            'limit' => $pagination->limit,
            'results' => $results,
            'size' => count($results),
            'start' => $pagination->offset,
            'total' => $totalCount,
        ];
    }
}
