<?php

use yii\db\Migration;

/**
 * Class m190221_050337_seed_users
 */
class m190221_050337_seed_users extends Migration
{
    public function safeUp()
    {
        $faker = \Faker\Factory::create();
        foreach ([1, 2] as $i) {
            $this->insert('user', [
                'id' => $i,
                'username' => 'user' . $i,
                'auth_key' => '',
                'password_hash' => '',
                'password_reset_token' => null,
                'created_at' => time(),
                'updated_at' => time(),
                'email' => $faker->email,
            ]);

            $this->insert('token', [
                'user_id' => $i,
                'token' => 'secrettoken' . $i,
                'expired_at' => time() + 86400 * 2
            ]);
        }
    }

    public function safeDown()
    {
        $this->delete('user');
        $this->delete('token');
    }
}
