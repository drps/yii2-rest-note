<?php

namespace api\models;

use common\models\Note;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class NoteSearch extends Note
{
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Note::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
