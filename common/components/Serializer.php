<?php

namespace common\components;

class Serializer extends \yii\rest\Serializer
{
    protected function serializePagination($pagination)
    {
        return [
            'count' => $pagination->totalCount,
            'pageCount' => $pagination->getPageCount(),
            'currentPage' => $pagination->getPage() + 1,
        ];
    }
}
