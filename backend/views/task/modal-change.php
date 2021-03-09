<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
/* @var array $userList */
/* @var array $statusList */
/* @var array $priorityList */
/* @var string $changeMod */
?>

<div class="change-form">
    <h3><?= Html::encode($model->title) ?></h3>

    <?php $form = ActiveForm::begin([
        'id' => 'change-modal',
        'method' => 'post',
        'action' => ['modal?id=' . $model->id.'&mod='.$changeMod]
    ]); ?>
    <div class="form-group">

        <?php
        switch ($changeMod) {
            case 'user':
                echo $form->field($model, 'user_id')
                    ->dropDownList($userList, ['prompt' => 'not set'])
                    ->label('Owner?');
                break;
            case 'priority':
                echo $form->field($model, 'priority_id')
                    ->dropDownList($priorityList, ['prompt' => 'select priority'])
                    ->label('Priority');
                break;
            case 'status':
                echo $form->field($model, 'status_id')->dropDownList($statusList, ['prompt' => 'select status'])
                    ->label('Status');
                break;
            default:
                echo "error";
        }
        ?>

        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
