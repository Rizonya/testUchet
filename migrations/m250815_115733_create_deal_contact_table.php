<?php
use yii\db\Migration;

class m250815_115733_create_deal_contact_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('deal_contact', [
            'deal_id' => $this->integer()->notNull(),
            'contact_id' => $this->integer()->notNull(),
        ]);

        // Первичный ключ составной (deal_id + contact_id)
        $this->addPrimaryKey('pk_deal_contact', 'deal_contact', ['deal_id', 'contact_id']);

        // Внешние ключи
        $this->addForeignKey(
            'fk_deal_contact_deal',
            'deal_contact',
            'deal_id',
            'deal',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_deal_contact_contact',
            'deal_contact',
            'contact_id',
            'contact',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_deal_contact_contact', 'deal_contact');
        $this->dropForeignKey('fk_deal_contact_deal', 'deal_contact');
        $this->dropTable('deal_contact');
    }
}
