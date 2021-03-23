<?php

use common\widgets\fileInput\FileInputWidget;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
/* @var array $userList */
/* @var array $managerList */
/* @var array $statusList */
/* @var array $statusColor */
/* @var array $priorityList */
$model->text = strip_tags($model->text);
$statusColor = array_map(function ($val) {
    return ["style" => "background-color:" . $val];
}, $statusColor);
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => '6']) ?>

    <?= $form->field($model, 'priority_id')->dropDownList($priorityList, ['prompt' => 'select priority'])
        ->label('Priority') ?>

    <?= $form->field($model, 'status_id')->dropDownList($statusList, ['prompt' => 'select status', 'options' => $statusColor])
        ->label('Status') ?>

    <?= $form->field($model, 'files[]')->widget(FileInputWidget::class) ?>

    <?= $form->field($model, 'user_id')->widget(Select2::class, [
        'data' => $userList,
        'theme' => Select2::THEME_DEFAULT,
        'options' => ['placeholder' => 'Select executor ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Executor') ?>

    <?php if (Yii::$app->user->can('admin'))
        echo $form->field($model, 'manager_id')->widget(Select2::class, [
            'data' => $userList,
            'theme' => Select2::THEME_DEFAULT,
            'options' => ['placeholder' => 'Select executor ...', 'options' => [Yii::$app->user->getId() => ['selected' => true]]],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Manager') ?>

    <?php if ($model->deletedAt !== null) echo $form->field($model, 'deletedAt')->textInput([
        'readonly' => true,
        'value' => Yii::$app->formatter->asDatetime($model->updatedAt, 'php:Y.m.d H:i:s'),
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
