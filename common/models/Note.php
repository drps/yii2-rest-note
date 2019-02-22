<?php

namespace common\models;

use common\models\query\NoteQuery;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "note".
 *
 * @property int $id
 * @property int $user_id
 * @property int $created_at
 * @property string $title
 * @property string $content
 *
 * @property User $user
 */
class Note extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'note';
    }

    public function rules()
    {
        return [
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'created_at' => 'Created at',
            'title' => 'Title',
            'content' => 'Content',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return NoteQuery
     */
    public static function find()
    {
        return new NoteQuery(get_called_class());
    }
}
