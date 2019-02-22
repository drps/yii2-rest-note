<?php

namespace api\models;

use common\models\Note;
use yii\base\Model;

class CreateNoteForm extends Model
{
    public $title;
    public $content;
    public $created_at;

    public function rules()
    {
        return [
            [['title', 'content', 'created_at'], 'required'],
            [['title', 'content'], 'string'],
            ['created_at', 'datetime', 'format' => 'php:Y-m-d H:i'],
        ];
    }

    public function note($userId)
    {
        if (!$this->validate()) {
            return null;
        }

        return new Note([
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => $userId,
            'created_at' => sprintf("%s:00", $this->created_at),
        ]);
    }
}
