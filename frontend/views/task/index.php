<?php

use backend\assets\ModalAsset;
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
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss("
.container-img{
    width: 100px;
    height: 100px;
    float: left; 
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover !important;
    margin: 5px;
}
");
//var_dump($statusList);exit();
?>
<div class="task-index">


    <div class="box box-info collapsed-box">
        <div class="box-header with-border"  data-widget="collapse">
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
        'hideOnSinglePage' => true,

    ]);
    ?>
    <div class="container-fluid">
        <div class="card-columns">
            <?php foreach ($dataProvider->getModels() as $model): ?>

                <div class="col-md-6">

                    <div class="box box-widget  bg-gray collapsed-box">
                        <div class="box-header with-border">
                            <!-- /.user-block -->

                            <div class="box-tools left">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="left" data-widget="collapse">
                                <i class="fa fa-tasks"></i>
                            </div>
                            <div class="box-tools label bg-orange">Priority: <?= $model->priority->name ?></div>

                            <div class="box-title">
                                <div class="user-block">
                                    <div class="title"><a
                                                href="/task/view?id=<?= $model->id ?>"><?= $model->title ?></a>
                                    </div>
                                    <div class="help-block small">Created
                                        at: <?= date("Y-m-d H:i:s", $model->createdAt) ?></div>
                                    <div class="help-block small">Updated
                                        at: <?= date("Y-m-d H:i:s", $model->updatedAt) ?></div>
                                </div>

                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" style="display: none;">
                            <!-- post text -->
                            <div class="box-body bg-gray-active ">
                                <div class=""> <?= $model->text ?></div>
                            </div>
                            <?php if ($model->attachmentFiles) : ?>
                                <!-- Attachment -->
                                <div class="clearfix bg-info">
                                    <?php foreach ($model->attachmentFiles as $file) : ?>
                                        <div class="container-img"
                                             style="background: url('http://tmback.test<?= Yii::$app->storage->getFile($file->name) ?>');">
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
                            <div class="fc-header-left"> Status: <?= $model->status->text ?> </div>
                        </div>
                        <div class="box-footer box-comments bg-gray" style="display: none;">
                            <?php if (!$model->status->finally || Yii::$app->user->can('manager')) : ?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-flat btn-sm">Change status</button>
                                    <button type="button" class="btn btn-info btn-flat btn-sm dropdown-toggle"
                                            data-toggle="dropdown"
                                            aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php foreach ($statusList as $status)
                                            if ($model->status_id !== $status['id'] && !$status['finally'])
                                                echo "<li style='background-color:".$status['color'].
                                                    " '><a href='/task/change-status?id=" . $model->id .
                                                    "&status=" . $status['id'] . "'>" . $status['text'] . "</a></li>";
                                        ?>
                                    </ul>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-flat btn-sm">Finish task</button>
                                    <button type="button" class="btn btn-success btn-flat btn-sm dropdown-toggle"
                                            data-toggle="dropdown"
                                            aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php foreach ($statusList as $status)
                                            if ($model->status_id !== $status['id'] && $status['finally'])
                                                echo "<li style='background-color:".$status['color'].
                                                    " '><a href='/task/change-status?id=" . $model->id .
                                                    "&status=" . $status['id'] . "'>" . $status['text'] . "</a></li>";
                                        ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if (Yii::$app->user->can('manager')) : ?>
                                <a class="mod user btn-sm" data-key="<?= $model->id ?>">
                                    Assigned to <?= ($model->user)? $model->user->username:'not set' ?>
                                </a>
                            <?php endif; ?>
                            <small class="pull-right  label bg-gray-active"> Manager: <?= $model->manager->username ?> </small>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
    <?= $this->render('../layouts/_modal-template', ['id' => 'modal-change']) ?>
