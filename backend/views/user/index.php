<?php

use backend\models\User;
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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
//            'auth_key',
//            'password_hash',
            'password_reset_token',
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
                'attribute' => 'role',
                'label' => 'Role',
                'filter' => User::getRoleList(),
                'content' => function ($model) {
                    return $model->getRoleDescriptions();
                }
            ],
            'created_at',
            'updated_at',
//            'verification_token',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
