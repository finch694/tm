<?php

namespace backend\models;

use common\models\Task;
use common\models\TaskQuery;
use common\models\UserQuery;
use ReflectionClass;
use Yii;
use common\models\User as CommonUser;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property Task[] $tasks
 * @property Task[] $managedTasks
 * @property Task[] $createdTasks
 */
class User extends CommonUser
{
    public $roleName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['username', 'email', 'updated_at'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['created_at'], 'integer'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
            [['roleName'], 'safe'],
            [['username','email'],'filter','filter' => '\yii\helpers\HtmlPurifier::process']
        ]);
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            ['class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'], // useless?
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ]]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'roleName' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     *
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->roleName = array_key_first(Yii::$app->authManager->getRolesByUser($this->id));
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->roleName);
        $auth->revokeAll($this->id);
        $auth->assign($role, $this->id);

        parent::afterSave($insert, $changedAttributes);
    }

    public function softDelete()
    {
        if ($this->status !== self::STATUS_DELETED){
            $this->status=self::STATUS_DELETED;
            return $this->save();
        }
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ManagedTasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getManagedTasks()
    {
        return $this->hasMany(Task::class, ['manager_id' => 'id']);
    }

    /**
     * Gets query for [[CreatedTasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getCreatedTasks()
    {
        return $this->hasMany(Task::class, ['creator_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find(): UserQuery
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        $statusList = [];
        $parentUser = new ReflectionClass(parent::class);
        foreach ($parentUser->getConstants() as $constName => $constValue) {
            if (strpos($constName, "STATUS_") === 0) {
                $statusList[$constValue] = strtolower(str_replace("STATUS_", '', $constName));
            }
        }
        return $statusList;
    }

    /**
     * @return string
     */
    public function getStatusText(): string
    {
        $statusList = self::getStatusList();
        if (array_key_exists($this->status, $statusList)) {
            return $statusList[$this->status];
        }
        return 'error';
    }

    /**
     * @return string
     */
    public function getRoleDescriptions(): string
    {
        return implode(' ', $roles = array_map(function ($role) {
            return $role->description;
        }, Yii::$app->authManager->getRolesByUser($this->id)));
    }

    /**
     * @return array
     */
    public static function getRoleList(): array
    {
        $roleList = [];
        foreach (Yii::$app->authManager->getRoles() as $role) {
            $roleList[$role->name] = $role->description;
        }
        return $roleList;
    }

    /**
     * @param $id
     * @return string
     */
    public static function getNameById($id)
    {
        if ($user= self::findIdentity($id)){
            return $user->username;
        }
    }
}
