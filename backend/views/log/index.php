<?php

use kartik\date\DatePicker;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index" style="overflow-x: auto;">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'Europe/Minsk',
            'dateFormat' => 'yyy MM dd',
            'datetimeFormat' => 'php: Y.m.d | H:i:s',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'log_time',
                'value' => 'log_time',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'log_time',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-MM-dd',
                        'todayHighlight' => true
                    ],
                    'convertFormat' => true,
                ]),
            ],
            [
                'label' => 'User',
                'attribute' => 'username',
                'value' => function ($model) {
                    if ($model->info !== null && array_key_exists('username', $model->info)) {
                        return $model->info->username;
                    } else {
                        return 'unknown';
                    }
                },
            ],
            'message:ntext',
            [
                'label' => 'IP',
                'attribute' => 'ip',
                'value' => function ($model) {
                    if ($model->info !== null && array_key_exists('ip', $model->info)) {
                        return $model->info->ip;
                    } else {
                        return 'unknown';
                    }
                },
            ],
        ],
    ]); ?>


</div>
