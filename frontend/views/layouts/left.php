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
            </div>
            <div class="pull-left info">
                <p><?= $user ?></p>
            </div>
        </div>

        <?php if (Yii::$app->user->isGuest) {
            echo dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                    'items' => [
                        ['label' => 'Home', 'icon' => 'home', 'url' => ['/']],
                        ['label' => 'Login', 'url' => ['site/login']],
                        ['label' => 'Signup', 'url' => ['site/signup']],

                    ],
                ]
            );
        } else {
            echo Yii::$app->user->can('manager') ?
                dmstr\widgets\Menu::widget(
                    ['options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                        'items' => [
                            ['label' => 'Home', 'icon' => 'home', 'url' => ['/']],
                            ['label' => 'Your tasks', 'icon' => 'link', 'url' => ['/task/my-tasks'],
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
                        ],
                    ]
                )
                :
                dmstr\widgets\Menu::widget(
                    ['options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                        'items' => [
                            ['label' => 'Home', 'icon' => 'home', 'url' => ['/']],
                            ['label' => 'Your tasks', 'icon' => 'link', 'url' => ['/task/my-tasks'],
                                'items' => [
                                    ['label' => 'Active tasks', 'icon' => 'square-o', 'url' => ['/task/my-active-tasks']],
                                    ['label' => 'Closed tasks', 'icon' => 'check-square-o', 'url' => ['/task/my-closed-tasks']],
                                    ['label' => 'All your tasks', 'icon' => 'clone', 'url' => ['/task/my-tasks']],
                                ]
                            ],
                            ['label' => 'All tasks', 'icon' => 'list-ol', 'url' => ['/task']],
                            ['label' => 'Unassigned tasks', 'icon' => 'unlink', 'url' => ['/task/unassigned-tasks']],
                        ],
                    ]
                );
        } ?>

    </section>
</aside>
