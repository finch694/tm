<?php

use backend\models\User;
use kartik\date\DatePicker;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var array $statusList */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'label' => 'Status',
                'filter' => $statusList,
                'content' => function ($model) {
                    return $model->getStatusText();
                }
            ],
            [
                'attribute' => 'roleName',
                'label' => 'Role',
                'filter' => User::getRoleList(),
                'content' => function ($model) {
                    return $model->getRoleDescriptions();
                }
            ],
            ['attribute' => 'created_at',
                'value' => 'created_at',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-MM-dd',
                        'todayHighlight' => true
                    ],
                    'convertFormat' => true,
                ]),
            ],['attribute' => 'updated_at',
                'value' => 'updated_at',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-MM-dd',
                        'todayHighlight' => true
                    ],
                    'convertFormat' => true,
                ]),
            ],
            ['class' => ActionColumn::class,
                'template' => (Yii::$app->user->can('admin'))? '{view} {update} {delete}': '{view}'
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
