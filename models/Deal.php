<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Deal extends ActiveRecord
{
    public static function tableName()
    {
        return 'deal';
    }

    public $contact_ids = [];

    public function getContactIds()
    {
        return ArrayHelper::getColumn($this->contacts, 'id');
    }



    public function rules()
    {
        return [
            [['name', 'amount'], 'required'],
            [['amount'], 'number'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    // Связь с контактами (многие ко многим)
    public function getContacts()
    {
        return $this->hasMany(Contact::class, ['id' => 'contact_id'])
            ->viaTable('deal_contact', ['deal_id' => 'id']);
    }
}
