<?php

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var array $userList */
/* @var array $managerList */
/* @var array $statusList */
/* @var array $statusColor */
/* @var array $priorityList */


$this->title = 'Create Task';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => Yii::$app->user->returnUrl ?: 'index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">



    <?= $this->render('_form', [
        'model' => $model,
        'userList' => $userList,
        'statusList'=>$statusList,
        'priorityList'=>$priorityList,
        'managerList'=>$managerList,
        'statusColor'=>$statusColor,
    ]) ?>

</div>
