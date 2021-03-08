<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var array $statusList */
/* @var array $priorityList */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('My tasks', ['my-index'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('All tasks', ['index'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Unassigned tasks', ['unassigned-index'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Tasks managed by me', ['managed-index'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Tasks created by me', ['created-index'], ['class' => 'btn btn-info']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'yyy MM dd',
            'datetimeFormat' => 'php: Y.m.d | H:i',
        ],
        'rowOptions' => function ($model) {
            if ($model->deletedAt !== null) {
                return [
                    'class' => 'error-summary',
                    'title' => 'deleted'
                ];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            [
                'attribute' => 'taskPriority',
                'label' => 'Priority',
                'filter' => $priorityList,
                'value' => 'priority.name'
            ],
            [
                'attribute' => 'taskStatus',
                'label' => 'Status',
                'filter' => $statusList,
                'value' => 'status.text',
                'contentOptions' =>
                    function ($model): array {
                        return ['style' => 'background:' . $model->status->color];
                    },
            ],
            'title',
            'text:raw',
            'files',
            [
                'attribute' => 'userName',
                'label' => 'Username',
                'value' => 'user.username'
            ],
            [
                'attribute' => 'managerName',
                'label' => 'Manager',
                'value' => 'manager.username'
            ],
            [
                'attribute' => 'creatorName',
                'label' => 'Creator',
                'value' => 'creator.username'
            ],
            [
                'attribute' => 'createdAt',
                'value' => 'createdAt',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'createdAt',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-MM-dd',
                        'todayHighlight' => true
                    ],
                    'convertFormat' => true,
                ]),
            ],
            [
                'attribute' => 'updatedAt',
                'value' => 'updatedAt',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updatedAt',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-MM-dd',
                        'todayHighlight' => true
                    ],
                    'convertFormat' => true,
                ]),
            ],
//            'createdAt:datetime',
//            'updatedAt:datetime',
//            'deletedAt:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
