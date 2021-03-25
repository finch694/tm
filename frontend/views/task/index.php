<?php

use backend\assets\ModalAsset;
use frontend\assets\ImageAsset;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var array $statusList */
/* @var array $managerList */
/* @var array $statusSearchList */
/* @var array $priorityList */
/* @var string $title */

ModalAsset::register($this);
ImageAsset::register($this);
$btnClass = Yii::$app->user->can('manager') ? 'btn mod' : '';
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
//var_dump($statusList);exit();
?>
<div class="task-index">


    <div class="box box-info collapsed-box">
        <div class="box-header with-border" data-widget="collapse">
            <h3 class="box-title">Search</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: none;">
            <?php echo $this->render('_search', [
                'model' => $searchModel,
                'statusList' => $statusSearchList,
                'priorityList' => $priorityList,
                'managerList' => $managerList,
            ]); ?>
        </div>

        <!-- /.box-body -->
    </div>
    <?php
    echo LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]);
    ?>
    <div class="summary">Showing <b>
            <?= $dataProvider->pagination->offset + 1; ?>-<?= ($dataProvider->pagination->page + 1) * $dataProvider->pagination->pageSize > $dataProvider->pagination->totalCount ? $dataProvider->pagination->totalCount : ($dataProvider->pagination->page + 1) * $dataProvider->pagination->pageSize ; ?> </b>
        of <b><?= $dataProvider->pagination->totalCount; ?></b> task.
    </div>
    <div class="container-fluid">
        <div class="card-columns">
            <?php foreach ($dataProvider->getModels() as $model):
                $mainBG = $model->deletedAt ? 'bg-black-gradient' : 'bg-gray';
                ?>
                <div class="col-md-6">
                    <div class="box box-widget  <?= $mainBG ?> collapsed-box">
                        <div class="box-header with-border">
                            <!-- /.user-block -->

                            <div class="box-tools left">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="left" data-widget="collapse">
                                <i class="fa fa-tasks"></i>
                            </div>
                            <div class="box-tools label bg-orange <?= $btnClass ?> priority"
                                 data-key="<?= $model->id ?>">Priority: <?= $model->priority->name ?> </div>

                            <div class="box-title">
                                <div class="user-block">
                                    <div class="title text-blue">
                                        <?= $model->deletedAt ? '<div class=" label text-red">Deleted</div>' : '' ?>
                                        <a href="/task/view?id=<?= $model->id ?>"><?= $model->title ?></a>
                                    </div>
                                    <div class="help-block small">Created
                                        at: <?= date("Y-m-d H:i:s", $model->createdAt) ?></div>
                                    <div class="help-block small"> <?= $model->deletedAt ? 'Deleted' : 'Updated' ?>
                                        at: <?= date("Y-m-d H:i:s", $model->updatedAt) ?></div>
                                </div>

                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" style="display: none;">
                            <!-- post text -->
                            <div class="box-body bg-gray-active ">
                                <div class=""> <?= $model->getTextWithLinks() ?></div>
                            </div>
                            <?php if ($model->attachmentFiles) : ?>
                                <!-- Attachment -->
                                <div class="clearfix bg-info">
                                    <?php foreach ($model->attachmentFiles as $file) : ?>
                                        <div class="container-img"
                                             style="background: url('http://tmback.test<?= Yii::$app->storage->getFile($file->name) ?>');">  <?php //todo url; ?>
                                            <a href="/task/download?id=<?= $file->id ?>" data-pjax="0"><i
                                                        class="glyphicon glyphicon-save"></i> </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <!-- /.attachment-block -->
                            <?php endif; ?>
                            <!-- Social sharing buttons -->

                        </div>
                        <!-- /.box-body -->
                        <div class="box-tools" style="background-color: <?= $model->status->color ?>">
                            <div class="fc-header-left <?= $btnClass ?> status btn-xs text-black"
                                 data-key="<?= $model->id ?>">
                                <b> Status: <?= $model->status->text ?></b>
                            </div>
                        </div>
                        <div class="box-footer box-comments <?= $mainBG ?>" style="display: none;">
                            <?php if (Yii::$app->user->can('manager') || !$model->status->finally && $model->user->id === Yii::$app->user->getId()) : ?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-flat btn-xs">Change status</button>
                                    <button type="button" class="btn btn-info btn-flat btn-xs dropdown-toggle"
                                            data-toggle="dropdown"
                                            aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php foreach ($statusList as $status)
                                            if ($model->status_id !== $status['id'] && !$status['finally'])
                                                echo "<li style='background-color:" . $status['color'] .
                                                    " '><a href='/task/change-status?id=" . $model->id .
                                                    "&status=" . $status['id'] . "'>" . $status['text'] . "</a></li>";
                                        ?>
                                    </ul>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-flat btn-xs">Finish task</button>
                                    <button type="button" class="btn btn-success btn-flat btn-xs dropdown-toggle"
                                            data-toggle="dropdown"
                                            aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php foreach ($statusList as $status)
                                            if ($model->status_id !== $status['id'] && $status['finally'])
                                                echo "<li style='background-color:" . $status['color'] .
                                                    " '><a href='/task/change-status?id=" . $model->id .
                                                    "&status=" . $status['id'] . "'>" . $status['text'] . "</a></li>";
                                        ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if (Yii::$app->user->can('manager') || !$model->user) : ?>
                                <a class="<?= $btnClass ?> user btn-sm"
                                   data-key="<?= $model->id ?>">
                                    Executor: <?= ($model->user) ? $model->user->username : 'not set' ?>
                                </a>
                            <?php endif; ?>
                            <div class="pull-right">
                                <?php
                                if (Yii::$app->user->can('admin')) {
                                    echo Html::a('<i class="fa fa-cogs"></i>', ['update', 'id' => $model->id], [
                                        'class' => 'btn btn-primary btn-flat margin-r-5 btn-xs',
                                        'title' => 'update'
                                    ]);
                                }
                                if (
                                    (Yii::$app->user->can('admin')
                                        && !$model->deletedAt
                                    )
                                    or
                                    (
                                        Yii::$app->user->can('manager')
                                        && !$model->deletedAt
                                        && $model->manager->id === Yii::$app->user->getId()
                                    )
                                ) {
                                    echo Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                                        'class' => 'btn btn-danger btn-flat margin-r-5 btn-xs',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this task?',
                                            'method' => 'post',
                                        ],
                                        'title' => 'delete'
                                    ]);
                                }
                                if (Yii::$app->user->can('admin') && $model->deletedAt) {
                                    echo Html::a('<i class="fa fa-reply"></i>', ['recover', 'id' => $model->id], [
                                        'class' => 'btn btn-info btn-flat margin-r-5 btn-xs',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to recover this task?',
                                            'method' => 'post',
                                        ],
                                        'title' => 'recover'
                                    ]);
                                }
                                ?>
                                <small class="pull-right <?= Yii::$app->user->can('admin') ? $btnClass : '' ?> manager label bg-gray-active"
                                       data-key="<?= $model->id ?>">
                                    Manager: <?= $model->manager->username ?> </small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?= $this->render('../layouts/_modal-template', ['id' => 'modal-change']) ?>
