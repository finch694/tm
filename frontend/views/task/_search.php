<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TaskSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $statusList array */
/* @var $managerList array */
/* @var $priorityList array */
?>

<div class="task-search">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="col-md-2">
        <?= $form->field($model, 'title') ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'status_id')->dropDownList($statusList, ['prompt' => 'Select status'])->label('Status') ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'priority_id')->dropDownList($priorityList, ['prompt' => 'Select priority'])->label('Priority') ?>
    </div>

    <div class="col-md-2">
        <?php echo $form->field($model, 'createdAt')->widget(DatePicker::class, [
            'model' => $model,
            'attribute' => 'createdAt',
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-MM-dd',
                'todayHighlight' => true
            ],
            'convertFormat' => true,
        ]) ?>
    </div>
    <div class="col-md-2">
        <?php echo $form->field($model, 'updatedAt')->widget(DatePicker::class, [
            'model' => $model,
            'attribute' => 'updatedAt',
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-MM-dd',
                'todayHighlight' => true
            ],
            'convertFormat' => true,
        ]) ?>
    </div>
    <div class="col-md-2">
        <?php echo $form->field($model, 'manager_id')->widget(Select2::class, [
            'data' => $managerList,
            'options' => ['placeholder' => 'Select a manager', 'disabled' => Yii::$app->request->pathInfo === 'task/managed-tasks'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Manager'); ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'text')->textarea() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
