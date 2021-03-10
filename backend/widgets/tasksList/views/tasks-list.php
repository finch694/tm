<?php
/* @var $taskList array */
$count = count($taskList);
?>
<li class="dropdown tasks-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-flag-o"></i>
        <span class="label label-danger"><?= $count ?></span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have <?= $count ?> open <?= ($count > 1) ? 'tasks' : 'task' ?></li>
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                <?php foreach ($taskList as $task): ?>
                    <li><!-- Task item -->
                        <a href="/task/view?id=<?= $task['id'] ?>">
                            <h3>
                                <?= $task['title'] ?>
                                <small class="pull-right"><?= $task['priority']['name'] ?></small>
                            </h3>
                            <div class="progress xs" style="background-color: <?= $task['status']['color'] ?>">
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>

            </ul>
        </li>
        <li class="footer">
            <a href="/task/my-tasks">View all your tasks</a>
        </li>
    </ul>
</li>