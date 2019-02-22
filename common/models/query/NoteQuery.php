<?php

namespace common\models\query;

class NoteQuery extends \yii\db\ActiveQuery
{
    public function active($authorId, $now = null)
    {
        $now = $now ?: date('Y-m-d H:i:s');
        
        return empty($authorId)
            ? $this->andWhere(['<', 'created_at', $now])
            : $this->andWhere([
            'OR',
            ['user_id' => $authorId],
            ['<', 'created_at', $now]
        ]);
    }

    public function latest($limit)
    {
        return $this->limit($limit)->orderBy(['id' => SORT_DESC]);
    }

    public function all($db = null)
    {
        return parent::all($db);
    }

    public function one($db = null)
    {
        return parent::one($db);
    }
}
