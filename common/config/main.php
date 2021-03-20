<?php

use backend\models\User;
use yii\web\Request;

return [
    'name' => 'Task app',
    'bootstrap' => ['log'],
    'timeZone' => 'Europe/Minsk',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'categories' => ['log'],
                    'prefix' => function ($message) {
                        $request = Yii::$app->getRequest();
                        $ip = $request instanceof Request ? $request->getUserIP() : '-';
                        $prefix['ip'] = $ip;
                        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        if ($user) {
                            $userID = $user->getId(false);
                            $prefix['userId'] = $userID;
                            $prefix['username'] = User::getNameById($userID);
                        }else{
                            $prefix['userId'] = 'unknown';
                            $prefix['username'] = 'unknown';
                        }
                        return json_encode($prefix);
                    }
                ],
            ],
        ],
        'storage' => [
            'class' => 'common\components\storage\Storage'
        ]
    ],
];
