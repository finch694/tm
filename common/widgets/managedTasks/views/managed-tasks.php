<?php

/**
 * @var $taskList  \common\models\Task
 * @var $closed boolean
 */

use yii\helpers\Html;

$count = count($taskList);
?>
<h3 class="control-sidebar-heading"> <?= $closed ? 'Closed ' : 'Active ' ?>Managed Tasks (<?= $count ?>)</h3>
<ul class='control-sidebar-menu' style="overflow: auto; max-height: 600px">

    <?php foreach ($taskList as $task): $username = $task->user->username ?? 'not set'; ?>
        <li>
            <?= Html::a("<h5>{$task['title']} 
                            <small class='pull-right label bg-orange'> {$task->priority->name}</small></h5>
                            <div class='xs small' style='background-color: {$task->status->color}; height: 14px; padding-inline: inherit;'>
                                <div class='pull-left text-black text-bold small'>{$task->status->text}</div>
                                <div class='pull-right text-black small'> $username </div>
                            </div>",
                ['/task/view?id=' . $task->id]) ?>
        </li>
    <?php endforeach; ?>
</ul>
<?= Html::a('Managed tasks', ['/task/managed-tasks'], ['class' => "control-sidebar-subheading label"]) ?>



