<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TaskStatus */

$this->title = 'Update Task Status: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-status-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
