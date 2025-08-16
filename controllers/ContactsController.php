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

class ContactsController extends Controller
{

    // Создание/редактирование сделки
    public function actionUpdate($id = null)
    {

        $model = $id ? $this->findModel($id) : new Contact();

        // Загружаем контакты
        $deals = Deal::find()->all();
        $dealList = [];
        foreach ($deals as $deal) {
            $dealList[$deal->id] = $deal->name;
        }

        // Загружаем POST
        if ($model->load(Yii::$app->request->post())) {


            // Получаем выбранные контакты
            $model->deal_ids = Yii::$app->request->post('Contact')['deal_ids'] ?? [];

            if ($model->save()) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // Текущие ID контактов сделки
                    $currentDealIds = ArrayHelper::getColumn($model->deals, 'id');
                    $newDealIds = (array)$model->deal_ids;

                    // Удаляем лишние связи
                    foreach (array_diff($currentDealIds, $newDealIds) as $dealId) {
                        $deal = Contact::findOne($dealId);
                        if ($deal) {
                            $model->unlink('deals', $deal, true);
                        }
                    }

                    // Добавляем новые связи
                    foreach (array_diff($newDealIds, $currentDealIds) as $dealId) {
                        $deal = Contact::findOne($dealId);
                        if ($deal) {
                            $model->link('deals', $deal);
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
            // Заполняем contact_ids для формы
            $model->deal_ids = \yii\helpers\ArrayHelper::getColumn($model->deals, 'id');
        }

        return $this->render('update', [
            'model' => $model,
            'dealList' => $dealList,
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
        $model = Contact::findOne($id);
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Сделка не найдена.');
    }
}
