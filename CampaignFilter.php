<?php

// .... asume we retrieved such campaign array from db
$campaign = [
    'id' => 1,
    'subject' => 'this is mail subject',
    'message' => 'this is mail message',
    'filter' => 'usersWithDolgVariant1',
    'params' => [1000],
];

$filter = $campaign['filter'];
$params = $campaign['filter_params'];

$query = CampaignFilter::applyFilter(
    User::find()->select(['id']),
    $filter,
    $params
);

$usersIds = $query->column();

class CampaignFilter
{
    public static function filtersList()
    {
        // или можно использовать рефлексию и все нужные методы называть filterSomething
        return [
            'usersWithDolgVariant1' => 'Users with dolg, params: int minAmount',
            'usersWithDolgVariant2' => 'Users with dolg as Array, params: int minAmount',
        ];
    }

    public static function applyFilter(Query $query, string $method, array $params = [])
    {
        // для второго варианта тут немного по другому будет
        $filter = new self();

        if (!method_exists($filter, $method)) {
            //@TODO log it
            return [];
        }
        
        array_unshift($params, $query);

        return call_user_func_array([$filter, $method], $params);
    }

    private function usersWithDolgVariant1(Query $query, int $minAmount): Query
    {
        return $query->where(['dolg', '>=', $minAmount]);
    }

    private function usersWithDolgVariant2(int $minAmount): array
    {
        return User::find()
            ->select(['id'])
            ->where(['dolg', '>=', $minAmount])
            ->orderBy('id')
            ->column();
    }
}

