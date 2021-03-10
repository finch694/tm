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
/* @var string $title */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="task-index">

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
                'text:raw',
                'files',
                [
                    'attribute' => 'userName',
                    'label' => 'Username',
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
<?= $this->render('../layouts/_modal-template', ['id' => 'modal-change']) ?>

<?php $this->registerJs("
$('.mod').on('click', function(){
let data = $(this).parent('tr').data();
let mod = $(this).attr('class');
mod = (mod.replace('mod','')).trim();
$('#modal-change').modal('show').find('.modal-body').load('/task/modal?id='+data.key+'&mod='+mod); 
});
");