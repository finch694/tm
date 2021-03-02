<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($model::getStatusList()) ?>

    <?= $form->field($model, 'created_at')->textInput([
        'readonly' => true,
        'disabled' => true,
        'value' => Yii::$app->formatter->asDatetime($model->created_at, 'php:Y.m.d H:i:s'),
    ]) ?>

    <?= $form->field($model, 'roleName')->dropDownList($model::getRoleList()) ?>

    <?= $form->field($model, 'updated_at')->textInput([
        'readonly' => true,
        'value' => Yii::$app->formatter->asDatetime($model->updated_at, 'php:Y.m.d H:i:s'),
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
