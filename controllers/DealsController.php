<?php

namespace app\controllers;

use Yii;
use app\models\Deal;
use app\models\Contact;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\log\Logger;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DealsController extends Controller
{

    // Создание/редактирование сделки
    public function actionUpdate($id = null)
    {
        $model = $id ? $this->findModel($id) : new Deal();

        // Загружаем все контакты для формы
        $contacts = Contact::find()->all();
        $contactList = \yii\helpers\ArrayHelper::map($contacts, 'id', function($c) {
            return $c->getFullName();
        });

        // Если форма отправлена
        if ($model->load(Yii::$app->request->post())) {
            // Берём выбранные контакты (массив ID)
            $model->contact_ids = Yii::$app->request->post('Deal')['contact_ids'] ?? [];

            if ($model->save()) {
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    // Текущие ID контактов, связанные с этой сделкой
                    $currentContactIds = $model->contactIds; // геттер getContactIds()

                    $newContactIds = (array) $model->contact_ids;

                    // Удаляем лишние связи
                    foreach (array_diff($currentContactIds, $newContactIds) as $contactId) {
                        $contact = Contact::findOne($contactId);
                        if ($contact) {
                            $model->unlink('contacts', $contact, true);
                        }
                    }

                    // Добавляем новые связи
                    foreach (array_diff($newContactIds, $currentContactIds) as $contactId) {
                        $contact = Contact::findOne($contactId);
                        if ($contact) {
                            $model->link('contacts', $contact);
                        }
                    }

                    $transaction->commit();
                    return $this->redirect('/');
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        } else {
            // Для формы: отмечаем уже связанные контакты
            $model->contact_ids = $model->contactIds; // геттер getContactIds()
        }

        return $this->render('update', [
            'model' => $model,
            'contactList' => $contactList,
        ]);
    }

    // Удаление сделки
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect('/');
    }

    protected function findModel($id)
    {
        $model = Deal::findOne($id);
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Сделка не найдена.');
    }
}
