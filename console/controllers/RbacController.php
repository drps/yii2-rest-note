<?php

namespace console\controllers;

use common\rbac\ChangeNoteRule;
use common\rbac\Rbac;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll();

        $rule = new ChangeNoteRule();
        $auth->add($rule);

        $changeNote = $auth->createPermission(Rbac::CHANGE_NOTE);
        $changeNote->ruleName = $rule->name;
        $auth->add($changeNote);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $changeNote);

        $auth->assign($user, 1);
        $auth->assign($user, 2);
    }
}
