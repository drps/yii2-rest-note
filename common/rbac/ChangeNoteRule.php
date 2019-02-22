<?php

namespace common\rbac;

use yii\rbac\Rule;

class ChangeNoteRule extends Rule
{
    const PERIOD = 86400;

    public $name = 'changeNote';
    public $description = 'Change note';

    public function execute($userId, $item, $params)
    {
        if (empty($params['note']['user'])) {
            throw new \InvalidArgumentException('You have to specify user for owning check.');
        }

        $can = $params['note']['user']->id == $userId;

        return $can && (strtotime($params['note']->created_at) > time() - self::PERIOD);
    }
}
