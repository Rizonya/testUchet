<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = [
            [
                'name' => 'Тема 1',
                'subtopics' => [
                    ['name' => 'Подтема 1.1', 'text' => 'Текст для Подтемы 1.1'],
                    ['name' => 'Подтема 1.2', 'text' => 'Текст для Подтемы 1.2'],
                    ['name' => 'Подтема 1.3', 'text' => 'Текст для Подтемы 1.3'],
                ]
            ],
            [
                'name' => 'Тема 2',
                'subtopics' => [
                    ['name' => 'Подтема 2.1', 'text' => 'Текст для Подтемы 2.1'],
                    ['name' => 'Подтема 2.2', 'text' => 'Текст для Подтемы 2.2'],
                    ['name' => 'Подтема 2.3', 'text' => 'Текст для Подтемы 2.3'],
                ]
            ]
        ];

        return $this->render('index', ['data' => $data]);
    }
}
