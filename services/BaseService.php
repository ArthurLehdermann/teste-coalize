<?php

namespace app\services;

use yii\helpers\Url;

class BaseService
{
    protected function getPaginationLinks($pagination)
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
