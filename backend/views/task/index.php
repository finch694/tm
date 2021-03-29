<?php

use backend\assets\ModalAsset;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var array $statusList */
/* @var array $priorityList */
/* @var string $title */

ModalAsset::register($this);
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'Europe/Minsk',
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
            'title',
            [
                'attribute' => 'taskStatus',
                'label' => 'Status',
                'filter' => $statusList,
                'value' => 'status.text',
                'contentOptions' =>
                    function ($model): array {
                        return ['style' => 'background:' . $model->status->color, 'class' => 'mod status'];
                    },
            ],
            [
                'attribute' => 'taskPriority',
                'label' => 'Priority',
                'filter' => $priorityList,
                'value' => 'priority.name',
                'contentOptions' => ['class' => 'mod priority']

            ],
            [
                'attribute' => 'text',
                'format' => 'html',
                'label' => 'Text',
                'contentOptions' => ['class' => 'truncate'],
                'value' => function ($model) {
                    return $model->getTextWithLinks();
                },
            ],
            [
                'label' => 'Attachment files',
                'format' => 'html',
                'contentOptions' => function ($model) {
                    return ($model->attachmentFiles) ? ['class' => 'file'] : [];
                },
                'content' => function ($model) {
                    if ($countFiles = count($model->attachmentFiles)) {
                        $limit = $countFiles > 1 ? 2 : 1;
                        $content = $countFiles > 2 ? '<div><small>Total files: <b>' . $countFiles . '</b></small></div>' : '';
                        for ($i = 0; $i < $limit; $i++) {
                            $content .=
                                Html::tag('div',
                                    Html::a(
                                        Html::tag('i', '', ['class' => 'glyphicon glyphicon-save']),
                                        "/task/download?id=" . $model->attachmentFiles[$i]['id'], ['data-pjax' => 0]),
                                    ['style' => 'background:url(' .
                                        Url::base(true) . Yii::$app->storage->getImgPreview($model->attachmentFiles[$i]['name']) . ');
                                    ', 'class' => 'img-min',
                                        'title'=>$model->attachmentFiles[$i]['native_name'],
                                    ]);
                        }
                        return $content;
                    }
                }
            ],

            [
                'attribute' => 'userName',
                'label' => 'Executor',
                'value' => 'user.username',
                'contentOptions' => ['class' => 'mod user']
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
                'contentOptions' => ['style' => 'width:130px;  min-width:130px;  '],
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
                'contentOptions' => ['style' => 'width:130px;  min-width:130px;  '],
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {recover}',
                'buttons' => [
                    'recover' => function ($url) {
                        return Html::a('<i class="glyphicon glyphicon-open"></i>', $url);
                    }
                ],
                'visibleButtons' => [
                    'delete' => function ($model) {
                        return $model->deletedAt == null;
                    },
                    'recover' => function ($model) {
                        return $model->deletedAt != null && Yii::$app->user->can('admin');
                    }
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<?= $this->render('../layouts/_modal-template-sm', ['id' => 'modal-change-sm']) ?>
<?= $this->render('../layouts/_modal-template-md', ['id' => 'modal-change-md']) ?>
