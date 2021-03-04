<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
/* @var array $userList */
/* @var array $statusList */
/* @var array $priorityList */

?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'files')->textInput() ?>

    <?= $form->field($model, 'status_id')->dropDownList($statusList,['prompt'=>'select status']) ?>

    <?= $form->field($model, 'user_id')->dropDownList($userList, ['prompt' => 'select user']) ?>

    <?= $form->field($model, 'manager_id')->dropDownList($userList, ['prompt' => 'select user']) ?>

    <?= $form->field($model, 'creator_id')->dropDownList($userList, ['prompt' => 'select user']) ?>

    <?= $form->field($model, 'createdAt')->textInput() ?>

    <?= $form->field($model, 'updatedAt')->textInput() ?>

    <?= $form->field($model, 'deletedAt')->textInput() ?>

    <?= $form->field($model, 'priority_id')->dropDownList($priorityList, ['prompt' => 'select priority']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
