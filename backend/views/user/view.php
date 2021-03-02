<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can('admin')): ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>
    <?= DetailView::widget([
        'model' => $model,
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'yyy MM dd',
            'datetimeFormat' => 'php: Y.m.d | H:i',
        ],
        'attributes' => [
            'id',
            'username',
            [
                'attribute' => 'role',
                'label' => 'Role',
                'value' => $model->getRoleDescriptions(),
            ],
            'password_reset_token',
            'email:email',
            [
                'attribute' => 'status',
                'label' => 'Status',
                'value' => $model->getStatusText()

            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
