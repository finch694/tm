<?php

use backend\models\User;
use common\widgets\tasksList\TasksList;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
$user = User::findIdentity(Yii::$app->user->getId());
if (isset($user)) {
    $role = $user->getRoleDescriptions();
    $username = $user->username;
} else {
    $username = $role = 'Guest';
}

?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">TASK</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <?= TasksList::widget() ?>


                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?= $username ?></span>
                    </a>
                    <ul class="dropdown-menu bg-light-blue-gradient">
                        <li class="text-center">
                            <p class="margin"><?= $username ?></p>
                            <p><small><?= $role ?></small></p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Logout',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
