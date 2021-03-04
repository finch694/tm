<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TaskPriority */

$this->title = 'Update Task Priority: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Task Priorities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-priority-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
