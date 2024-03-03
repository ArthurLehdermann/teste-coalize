<?php

namespace app\services;

use app\models\Product;
use Yii;
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
        $product = Product::find()
            ->where(['id' => $id])
            ->with('customer')
            ->one();

        if (!$product) {
            throw new NotFoundHttpException(Yii::t('app', 'Product not found'));
        }

        return $product;
    }

    public function update($id, $data)
    {
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException(Yii::t('app', 'Product not found'));
        }

        $product->attributes = $data;
        $product->save();

        return $product;
    }

    public function delete($id)
    {
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException(Yii::t('app', 'Product not found'));
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
            '_links' => $this->getPaginationLinks($pagination),
            'limit' => $pagination->limit,
            'results' => $results,
            'size' => count($results),
            'start' => $pagination->offset,
            'total' => $totalCount,
        ];
    }
}
