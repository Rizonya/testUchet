<?php
use yii\db\Migration;

class m250815_115244_create_deal_and_contact_tables extends Migration
{
    public function safeUp()
    {
        // Таблица Сделка
        $this->createTable('deal', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'amount' => $this->decimal(15,2)->notNull(),
        ]);

        // Таблица Контакт
        $this->createTable('contact', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('contact');
        $this->dropTable('deal');
    }
}
