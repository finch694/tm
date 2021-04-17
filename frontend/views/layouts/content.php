<?php

use common\widgets\managedTasks\ManagedTasksWidget;
use common\widgets\tasksSummary\TasksSummary;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

/* @var $content string */
?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo Html::encode($this->title);
                } else {
                    echo Inflector::camel2words(
                        Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>
        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong>Task application</strong>
</footer>

<aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-info-tab" data-toggle="tab"><i class="fa fa-info"></i></a></li>
        <?php if (Yii::$app->user->can('manager')) : ?>
            <li><a href="#control-sidebar-active-tab" data-toggle="tab"><i class="fa fa-circle-o"></i></a></li>
            <li><a href="#control-sidebar-closed-tab" data-toggle="tab"><i class="fa fa-check-circle-o"></i></a></li>
        <?php endif; ?>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="control-sidebar-info-tab">
            <?= Yii::$app->user->can('manager') ? Html::a('Create Task', ['task/create'], ['class' => 'center-block btn btn-success btn-flat']) : '' ?>
            <?= TasksSummary::widget() ?>
        </div>
        <?php if (Yii::$app->user->can('manager')) : ?>
            <div class="tab-pane" id="control-sidebar-active-tab">
                <?= ManagedTasksWidget::widget() ?>
            </div>

            <div class="tab-pane" id="control-sidebar-closed-tab">
                <?= ManagedTasksWidget::widget(['mode' => ManagedTasksWidget::MT_CLOSED]) ?>
            </div>
        <?php endif; ?>
    </div>
</aside>
<div class='control-sidebar-bg tab-pane'>
</div>
