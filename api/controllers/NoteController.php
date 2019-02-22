<?php

namespace api\controllers;

use api\models\CreateNoteForm;
use common\components\Serializer;
use common\models\Note;
use common\rbac\Rbac;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class NoteController extends Controller
{
    public $modelClass = 'common\models\Note';
    public $serializer = [
        'class' => Serializer::class,
        'collectionEnvelope' => 'records',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'optional' => ['index', 'show'],
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
        $userId = $this->userId();

        $dataProvider = new ActiveDataProvider([
            'query' => Note::find()->active($userId),
            'pagination' => [
                'pageSize' => 5,
                'defaultPageSize' => 5,
                'pageParam' => 'p',
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'id' => SORT_ASC,
                ]
            ],
        ]);

        return $dataProvider;
    }

    public function actionShow($id)
    {
        $userId = $this->userId();

        if ($note = Note::find()->active($userId)->andWhere(['id' => $id])->one()) {
            return $note;
        }

        throw new NotFoundHttpException('Not found');
    }

    public function actionCreate()
    {
        $form = new CreateNoteForm();
        $form->load(Yii::$app->request->post(), '');

        if (!$note = $form->note($this->userId())) {
            return $form;
        }

        if ($note->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $response->getHeaders()->set('Location', Url::toRoute(['show', 'id' => $note->id], true));
        } elseif (!$note->hasErrors()) {
            throw new ServerErrorHttpException('Some error occurred while creation');
        }


        return $note;
    }

    public function actionUpdate($id)
    {
        if (!$note = Note::findOne($id)) {
            throw new NotFoundHttpException('Not found');
        }

        if (!Yii::$app->user->can(Rbac::CHANGE_NOTE, ['note' => $note])) {
            throw new ForbiddenHttpException('Forbidden');
        }

        $form = new CreateNoteForm();
        $form->load(Yii::$app->request->bodyParams, '');

        if (!$form->validate()) {
            return $form;
        }

        $note->title = $form->title;
        $note->content = $form->content;
        $note->created_at = sprintf("%s:00", $form->created_at);

        if ($note->save() === false && !$note->hasErrors()) {
            throw new ServerErrorHttpException('Update failed.');
        }


        return $note;
    }

    public function actionDelete($id)
    {
        if ($note = Note::findOne($id)) {
            if (!Yii::$app->user->can(Rbac::CHANGE_NOTE, ['note' => $note])) {
                throw new ForbiddenHttpException('Forbidden');
            }

            $note->delete();
        }

        $response = Yii::$app->getResponse();
        $response->setStatusCode(204);
        $response->getHeaders()->set('Location', Url::toRoute(['index'], true));

        return [];
    }

    private function userId()
    {
        return ($user = \Yii::$app->user) ? $user->id : null;
    }
}
