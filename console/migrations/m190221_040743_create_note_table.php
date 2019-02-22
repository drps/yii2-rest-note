<?php

use yii\db\Migration;

class m190221_040743_create_note_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%note}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'title' => $this->string(),
            'content' => $this->text(),
        ]);
        $this->createIndex('idx-note-user_id', '{{%note}}', 'user_id');
        $this->addForeignKey('fk-note-user_id', '{{%note}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable('{{%note}}');
    }
}
