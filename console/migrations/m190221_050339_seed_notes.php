<?php

use yii\db\Migration;

class m190221_050339_seed_notes extends Migration
{
    public function safeUp()
    {
        $faker = \Faker\Factory::create();
        foreach ([1, 2] as $userId) {
            $this->insert('note', [
                'user_id' => $userId,
                'created_at' => (new \DateTimeImmutable())->modify("-2 day")->format('Y-m-d H:i:s'),
                'title' => 'Too old note from user' . $userId,
                'content' => $faker->sentence,
            ]);

            $this->insert('note', [
                'user_id' => $userId,
                'created_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                'title' => $faker->sentence,
                'content' => $faker->sentence,
            ]);

            $this->insert('note', [
                'user_id' => $userId,
                'created_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                'title' => $faker->sentence,
                'content' => $faker->sentence,
            ]);

            $this->insert('note', [
                'user_id' => $userId,
                'created_at' => (new \DateTimeImmutable())->modify("+2 day")->format('Y-m-d H:i:s'),
                'title' => 'Note from future from user' . $userId,
                'content' => $faker->sentence,
            ]);
        }
    }

    public function safeDown()
    {
        $this->delete('note');
    }
}
