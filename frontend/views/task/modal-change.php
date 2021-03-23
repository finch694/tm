<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
/* @var array $userList */
/* @var array $statusList */
/* @var array $statusColor */
/* @var array $priorityList */
/* @var string $changeMod */
$statusColor = array_map(function ($val){ return  ["style"=>"background-color:".$val];},$statusColor);
?>

<div class="change-form">
    <h3><?= Html::encode($model->title) ?></h3>

    <?php $form = ActiveForm::begin([
        'id' => 'change-modal',
        'method' => 'post',
        'action' => ['modal?id=' . $model->id . '&mod=' . $changeMod]
    ]); ?>
    <div class="form-group">

        <?php
        switch ($changeMod) {
            case 'user':
                echo $form->field($model, 'user_id')->widget(Select2::class,[
                    'data' => $userList,
                    'theme' => Select2::THEME_DEFAULT,
                    'options' => ['placeholder' => 'Select executor ...', 'class'=>'form-control'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Executor');
//                    ->dropDownList($userList, ['prompt' => 'not set'])
//                    ->label('Executor');
                break;
            case 'priority':
                echo $form->field($model, 'priority_id')
                    ->dropDownList($priorityList, ['prompt' => 'select priority'])
                    ->label('Priority');
                break;
            case 'status':
                echo $form->field($model, 'status_id')->dropDownList($statusList, ['prompt' => 'select status',
                    'options' => $statusColor])
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
