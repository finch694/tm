<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var array $userList */
/* @var array $statusList */
/* @var array $priorityList */


$this->title = 'Create Task';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">



    <?= $this->render('_form', [
        'model' => $model,
        'userList' => $userList,
        'statusList'=>$statusList,
        'priorityList'=>$priorityList,
    ]) ?>

</div>
