<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Deal;
use app\models\Contact;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $contactsBD = Contact::find()->all();
        $contacts = [];

        foreach ($contactsBD as $contact) {
            $data = [];
            $data['id'] = $contact->id;
            $data['label'] = $contact->getFullName();

            // Все сделки контакта
            $dealsData = [];
            foreach ($contact->getDeals()->all() as $deal) {
                $dealsData[] = [
                    'id' => $deal->id,
                    'label' => $deal->name
                ];
            }
            $data['deals'] = $dealsData;

            $contacts[] = $data;
        }

// Аналогично для сделок
        $dealsBD = Deal::find()->all();
        $deals = [];

        foreach ($dealsBD as $deal) {
            $dealData = [];
            $dealData['id'] = $deal->id;
            $dealData['label'] = $deal->name;
            $dealData['amount'] = $deal->amount;

            $contactsData = [];
            foreach ($deal->getContacts()->all() as $contact) {
                $contactsData[] = [
                    'id' => $contact->id,
                    'label' => $contact->getFullName()
                ];
            }
            $dealData['contacts'] = $contactsData;

            $deals[] = $dealData;
        }


        return $this->render('index', [
            'contacts' => $contacts,
            'deals' => $deals,
        ]);
    }

}
