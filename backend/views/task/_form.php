<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
/* @var array $userList */
/* @var array $statusList */
/* @var array $priorityList */
$model->text = strip_tags($model->text);
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => '6']) ?>

    <?= $form->field($model, 'priority_id')->dropDownList($priorityList, ['prompt' => 'select priority'])
        ->label('Priority') ?>

    <?= $form->field($model, 'status_id')->dropDownList($statusList, ['prompt' => 'select status'])
        ->label('Status') ?>

    <?= $form->field($model, 'files')->textInput() //todo upload   ?>

    <?= $form->field($model, 'user_id')->dropDownList($userList, ['prompt' => 'not set'])->label('Owner?') ?>

    <?php if (Yii::$app->user->can('admin'))
        echo $form->field($model, 'manager_id')->dropDownList($userList, ['prompt' => 'select user'])
            ->label('Manager') ?>

    <?php if ($model->deletedAt !== null) echo $form->field($model, 'deletedAt')->textInput([
        'readonly' => true,
        'value' => Yii::$app->formatter->asDatetime($model->updatedAt, 'php:Y.m.d H:i:s'),
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
