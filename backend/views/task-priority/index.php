<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TaskPrioritySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Priorities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-priority-index">



    <p>
        <?= Html::a('Create Task Priority', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'value',
            'active:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {change-active}',
                'buttons' => [
                    'change-active' => function ($url, $model) {
                        $icon = $model->active ? 'glyphicon-remove' : 'glyphicon-ok';
                        return Html::a("<i class='glyphicon {$icon}'></i>", $url);
                    },
                ],
            ],
        ]]); ?>

    <?php Pjax::end(); ?>

</div>
