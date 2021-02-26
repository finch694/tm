<?php


namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacStartController extends Controller
{
    /**
     * @throws \yii\base\Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);

        $manager = $auth->createRole('manager');
        $manager->description = 'Manager';
        $auth->add($manager);

        $user = $auth->createRole('User');
        $user->description = 'user';
        $auth->add($user);

        $banned = $auth->createRole('banned');
        $banned->description = 'Banned user';
        $auth->add($banned);

        $permit = $auth->createPermission('manageTask');
        $permit->description = 'Ability to manage tasks';
        $auth->add($permit);

        $auth->addChild($manager, $user);
        $auth->addChild($manager, $permit);
        $auth->addChild($admin, $manager);
    }
}