<?php

namespace app\services;

use app\models\Customer;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class CustomerService
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
            throw new NotFoundHttpException('Cliente não encontrado');
        }

        return $customer;
    }

    public function update($id, $data)
    {
        $customer = Customer::findOne($id);
        if (!$customer) {
            throw new NotFoundHttpException('Cliente não encontrado');
        }

        $customer->attributes = $data;
        $customer->save();

        return $customer;
    }

    public function delete($id)
    {
        $customer = Customer::findOne($id);
        if (!$customer) {
            throw new NotFoundHttpException('Cliente não encontrado');
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
            '_links' => $this->getPaginationLinks($conditions, $pagination),
            'limit' => $pagination->limit,
            'results' => $results,
            'size' => count($results),
            'start' => $pagination->offset,
            'total' => $totalCount,
        ];
    }

    private function getPaginationLinks($conditions, $pagination)
    {
        $currentUrl = Url::current([], true);

        $nextUrl = $currentUrl;
        $prevUrl = $currentUrl;

        $page = $pagination->getPage();
        if ($page > 0) {
            $prevUrl = $pagination->createUrl($page -1, $pagination->limit, true);
        }

        if ($page < ($pagination->getPageCount() -1)) { // Yii2's Pagination page index is 0-based
            $nextUrl = $pagination->createUrl($page +1, $pagination->limit, true);
        }

        return [
            'current' => $currentUrl,
            'next' => $nextUrl,
            'prev' => $prevUrl,
        ];
    }
}