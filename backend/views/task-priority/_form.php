<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TaskPriority */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-priority-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['type'=>'number', 'title'=>'The numerical value of the priority. (the less, the more priority)']) ?>

    <?= $form->field($model, 'active')->checkbox([ 'value' => '1', 'checked ' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
