<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Contact extends ActiveRecord
{
    public static function tableName()
    {
        return 'contact';
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 30],
        ];
    }

    public $deal_ids=[];
    // Связь с сделками (многие ко многим)
    public function getDeals()
    {
        return $this->hasMany(Deal::class, ['id' => 'deal_id'])
            ->viaTable('deal_contact', ['contact_id' => 'id']);
    }

    public function getDealIds()
    {
        return ArrayHelper::getColumn($this->deals, 'id');
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
