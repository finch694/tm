<?php $user = Yii::$app->user->identity;
if (isset($user)) {
    $user = $user->username;
} else {
    $user = 'Guest';
}
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <br>
                <!--                <img src="-->
                <? //= $directoryAsset ?><!--/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>-->
            </div>
            <div class="pull-left info">
                <p><?= $user ?></p>

                <!--                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
        </div>

        <!-- search form -->
        <!--        <form action="#" method="get" class="sidebar-form">-->
        <!--            <div class="input-group">-->
        <!--                <input type="text" name="q" class="form-control" placeholder="Search..."/>-->
        <!--              <span class="input-group-btn">-->
        <!--                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>-->
        <!--                </button>-->
        <!--              </span>-->
        <!--            </div>-->
        <!--        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Home', 'icon' => 'home', 'url' => ['/']],
                    [
                        'label' => 'Tasks', 'icon' => 'list-ol', 'url' => '/task',
                        'items' => [
                            [
                                'label' => 'Your tasks', 'icon' => 'link', 'url' => ['/task/my-tasks'],
                                'items' => [
                                    ['label' => 'Active tasks', 'icon' => 'square-o', 'url' => ['/task/my-active-tasks']],
                                    ['label' => 'Closed tasks', 'icon' => 'check-square-o', 'url' => ['/task/my-closed-tasks']],
                                    ['label' => 'All your tasks', 'icon' => 'clone', 'url' => ['/task/my-tasks']],
                                ]
                            ],
                            ['label' => 'All tasks', 'icon' => 'list-ol', 'url' => ['/task']],
                            ['label' => 'Unassigned tasks', 'icon' => 'unlink', 'url' => ['/task/unassigned-tasks']],
                            ['label' => 'Your managed tasks', 'icon' => 'search', 'url' => ['/task/managed-tasks']],
                            ['label' => 'Your created tasks', 'icon' => 'pencil', 'url' => ['/task/created-tasks']],
                            ['label' => 'Deleted tasks', 'icon' => 'trash', 'url' => ['/task/deleted-tasks'], 'visible' => Yii::$app->user->can('admin')],
                        ]
                    ],
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Users', 'icon' => 'users', 'url' => ['/user']],
                    [
                        'label' => 'Task tools',
                        'icon' => 'cogs',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Statuses', 'icon' => 'tag', 'url' => ['/task-status']],
                            ['label' => 'Priority', 'icon' => 'exclamation', 'url' => ['/task-priority']]
                        ]
                    ],
                    ['label' => 'Log', 'icon' => 'history', 'url' => ['/log'], 'visible' => Yii::$app->user->can('admin')],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

    </section>

</aside>
