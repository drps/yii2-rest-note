<?php

namespace common\models;

/**
 * This is the model class for table "token".
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property int $expired_at
 *
 * @property User $user
 */
class Token extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'token';
    }

    public function fields()
    {
        return [
            'token' => $this->token,
            'expired_at' => date('Y-m-d H:i:s', $this->expired_at),
        ];
    }
}
