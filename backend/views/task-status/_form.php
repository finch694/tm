<?php

use kartik\color\ColorInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TaskStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->widget(ColorInput::class, [
        'useNative' => true,
//        'size' => 'sm',
        'options' => ['placeholder' => 'Select color ...'],
    ]); ?>

    <?php if ($model->deletedAt) {
        echo Html::label('Deleted at').'<br>';
        echo Html::input('text', null, Yii::$app->formatter->asDatetime($model->deletedAt, 'php:d.m.Y H:i:s'), ['readonly' => true, 'class'=>'form-control']);
//    $form->field($model, 'deletedAt')->textInput(['maxlength' => true,
//        'readonly'=> true,
//        'value' => Yii::$app->formatter->asDatetime($model->deletedAt, 'php:d.m.Y H:i:s'),])
    } ?>

    <?= $form->field($model, 'finally')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
