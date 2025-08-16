<?php

use yii\db\Migration;

class m250815_120252_seed_deals_and_contacts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Примеры сделок
        $this->batchInsert('deal', ['name','amount'], [
            ['Сделка 1', 1000],
            ['Сделка 2', 5000],
        ]);

        // Примеры контактов
        $this->batchInsert('contact', ['first_name','last_name'], [
            ['Иван', 'Иванов'],
            ['Пётр', 'Петров'],
        ]);

        // Связи сделка - контакт
        $this->batchInsert('deal_contact', ['deal_id','contact_id'], [
            [1,1],
            [1,2],
            [2,2],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('deal_contact');
        $this->truncateTable('contact');
        $this->truncateTable('deal');
    }

}