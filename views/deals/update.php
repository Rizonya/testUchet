<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Deal */
/* @var $contactList array */

$this->title = $model->isNewRecord ? 'Создать сделку' : 'Редактировать сделку';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="deal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'contact_ids')->checkboxList($contactList) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
