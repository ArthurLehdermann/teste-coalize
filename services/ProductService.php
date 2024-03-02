<?php

namespace app\services;

use app\models\Product;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class ProductService extends BaseService
{
    public function create($data)
    {
        $product = new Product;
        $product->attributes = $data;
        $product->save();

        return $product;
    }

    public function read($id)
    {
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException('Produto não encontrado');
        }

        return $product;
    }

    public function update($id, $data)
    {
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException('Produto não encontrado');
        }

        $product->attributes = $data;
        $product->save();

        return $product;
    }

    public function delete($id)
    {
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException('Produto não encontrado');
        }

        $product->delete();

        return $product;
    }

    public function list($conditions = [])
    {
        $page = (int) ($conditions['page'] ?? 1);
        unset($conditions['page']);

        $pageSize = (int) ($conditions['pageSize'] ?? 10);
        unset($conditions['pageSize']);

        $query = Product::find()->where($conditions);

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
}