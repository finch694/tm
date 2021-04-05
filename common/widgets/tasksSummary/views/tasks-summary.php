<?php

/**
 * @var $tasksSummary array
 * @var $totalCount int
 */

use yii\helpers\Html;

?>
<h3 class="control-sidebar-heading">Tasks Statuses</h3>
<ul class='control-sidebar-menu' style="overflow: auto; max-height: 500px">
    <?php foreach ($tasksSummary as $info) : ?>
        <li>
            <a>
                <h4 class="control-sidebar-subheading">
                    <?= $info['status']['text'] . ' (' . $info['count'].')' ?>
                    <span class="label text-black pull-right"
                          style="background-color: <?= $info['status']['color'] ?>"><?= $totalCount ? round($info['count'] / $totalCount * 100, 2) : '0' ?>%</span>
                </h4>
                <div class="progress progress-xxs">
                    <div class="progress-bar"
                         style="width: <?= $info['count'] / $totalCount * 100 ?>%; background-color: <?= $info['status']['color'] ?>"></div>
                </div>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<?= Html::a('Total tasks: ' . $totalCount, ['/task'], ['class' => "control-sidebar-subheading label"]) ?>
