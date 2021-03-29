<?php

/**
 * @var $taskList  \common\models\Task
 * @var $closed boolean
 */

$count = count($taskList);
?>
<h3 class="control-sidebar-heading"> <?= $closed ? 'Closed ' : 'Active ' ?>Managed Tasks (<?= $count ?>)</h3>
<ul class='control-sidebar-menu' style="overflow: auto; max-height: 600px">

    <?php foreach ($taskList as $task): ?>
        <li>
            <a href="/task/view?id=<?= $task->id ?>">
                <h5>
                    <?= $task['title'] ?>
                    <small class="pull-right label bg-orange"><?= $task->priority->name ?></small>
                </h5>
                <div class="xs small" style="background-color: <?= $task->status->color ?>; height: 14px; padding-inline: inherit;">
                    <div class="pull-left text-black text-bold small"><?= $task->status->text ?></div>
                    <div class="pull-right text-black small"> <?= $task->user->username ?? 'non set' ?> </div>
                </div>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<a href="/task/managed-tasks" class="control-sidebar-subheading label">Managed tasks</a>


