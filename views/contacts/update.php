<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Deal */
/* @var $dealList array */

$this->title = $model->isNewRecord ? 'Создать контакт' : 'Редактировать контакт';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="deal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'last_name')->textInput() ?>

    <?= $form->field($model, 'deal_ids')->checkboxList($dealList) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
