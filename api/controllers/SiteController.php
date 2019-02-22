<?php

namespace api\controllers;

use common\models\Note;
use common\rbac\Rbac;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'except' => ['index', 'login'],
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $note = Note::findOne(34);

        if (\Yii::$app->user->can(Rbac::CHANGE_NOTE, ['note' => $note])) {
            return 'apiv1.1';
        }
        return ['version' => 'apiv1.0'];
    }

    public function actionLogin()
    {
        throw new \Exception('Not implemented');
    }

    protected function verbs()
    {
        return [
            'login' => 'post',
        ];
    }
}
