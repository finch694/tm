<?php

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var array $userList */
/* @var array $managerList */
/* @var array $statusList */
/* @var array $statusColor */
/* @var array $priorityList */

$this->title = 'Update Task: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-update">



    <?= $this->render('_form', [
        'model' => $model,
        'userList' => $userList,
        'statusList'=>$statusList,
        'priorityList'=>$priorityList,
        'managerList'=>$managerList,
        'statusColor'=>$statusColor,
    ]) ?>

</div>
