<?php


namespace console\controllers;


use common\models\User;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class RbacAdminAssignController extends Controller
{
    public function actionInit($id){
        if (!$id || is_integer($id)){
            $this->stdout('id must be correct\n',Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        $user = (new User())->findIdentity($id);
        if (!$user){
            $this->stdout("User with id:{$id} is not found\n",Console::BG_YELLOW);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        $auth = Yii::$app->authManager;
        $roleAdmin = $auth->getRole('admin');
        $auth->revokeAll($id);
        $auth->assign($roleAdmin,$id);
        $this->stdout('done\n',Console::BG_GREEN);
        return ExitCode::OK;

    }
}