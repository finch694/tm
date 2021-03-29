<?php

/**
 * @var $tasksSummary array
 * @var $totalCount int
 */

?>
<h3 class="control-sidebar-heading">Tasks Statuses</h3>
<ul class='control-sidebar-menu' style="overflow: auto; max-height: 500px">
    <?php foreach ($tasksSummary as $info) : ?>
        <li>
            <a>
                <h4 class="control-sidebar-subheading">
                    <?= $info['text'] ?>
                    <span class="label text-black pull-right" style="background-color: <?=  $info['color'] ?>"><?=round( $info['count']/$totalCount*100,2)?>%</span>
                </h4>
                <div class="progress progress-xxs">
                    <div class="progress-bar" style="width: <?=$info['count']/$totalCount*100?>%; background-color: <?= $info['color'] ?>"></div>
                </div>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<a href="/task" class="control-sidebar-subheading label">Total tasks: <?=$totalCount?></a>
