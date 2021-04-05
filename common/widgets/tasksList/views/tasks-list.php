<?php

/**
 * @var $taskList array
 */

use yii\helpers\Html;

$count = count($taskList);
?>
<li class="dropdown tasks-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-flag-o"></i>
        <?php if ($count) : ?>
            <span class="label label-danger"><?= $count ?></span>
        <?php endif; ?>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have <?= $count ?> open <?= ($count > 1) ? 'tasks' : 'task' ?></li>
        <li>
            <ul class="menu">
                <?php foreach ($taskList as $task): ?>
                    <li>
                        <?= Html::a("<h3>{$task['title']} 
                            <small class='pull-right'> {$task['priority']['name']}</small></h3>
                            <div class='progress xs' style='background-color: {$task["status"]["color"]}'></div>",
                            ['/task/view?id='.$task["id"]]) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li class="footer">
            <?= Html::a('View all your tasks', ['task/my-tasks']) ?>
        </li>
    </ul>
</li>
