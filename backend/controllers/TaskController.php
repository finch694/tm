<?php

namespace backend\controllers;

use common\models\TaskPriority;
use common\models\TaskStatus;
use common\models\User;
use Yii;
use common\models\Task;
use common\models\TaskSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->index($searchModel, $dataProvider);
    }

    public function actionManagedIndex()
    {
        $searchModel = new TaskSearch();
        $params['TaskSearch'] = ['manager_id' => Yii::$app->user->id];
        $dataProvider = $searchModel->search(array_merge_recursive(Yii::$app->request->queryParams, $params));
        return $this->index($searchModel, $dataProvider);
    }

    public function actionCreatedIndex()
    {
        $searchModel = new TaskSearch();
        $params['TaskSearch'] = ['creator_id' => Yii::$app->user->id];
        $dataProvider = $searchModel->search(array_merge_recursive(Yii::$app->request->queryParams, $params));
        return $this->index($searchModel, $dataProvider);
    }

    public function actionUnassignedIndex()
    {
        $searchModel = new TaskSearch();
        $params['TaskSearch'] = ['user_id' => 0];
        $dataProvider = $searchModel->search(array_merge_recursive(Yii::$app->request->queryParams, $params));
        return $this->index($searchModel, $dataProvider);
    }
    public function actionMyIndex()
    {
        $searchModel = new TaskSearch();
        $params['TaskSearch'] = ['user_id' => Yii::$app->user->id];
        $dataProvider = $searchModel->search(array_merge_recursive(Yii::$app->request->queryParams, $params));
        return $this->index($searchModel, $dataProvider);
    }

    public function index(TaskSearch $searchModel, ActiveDataProvider $dataProvider)
    {
        $statusList = TaskStatus::find()
            ->select(['text', 'id'])
            ->andWhere(['deletedAt' => null])
            ->indexBy('id')
            ->asArray()
            ->column();
        $priorityList = TaskPriority::find()
            ->select(['name', 'id'])
            ->andWhere(['active' => true])
            ->indexBy('id')
            ->asArray()
            ->column();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusList' => $statusList,
            'priorityList' => $priorityList,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();
        return $this->taskCreateOrUpdate($model, 'create');
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->taskCreateOrUpdate($model, 'update');
    }

    /**
     * @param Task $model
     * @param string $view
     * @return string|\yii\web\Response
     */
    public function taskCreateOrUpdate(Task $model, string $view)
    {
        $userList = User::find()
            ->select(['username', 'id'])
            ->leftJoin('auth_assignment', '"user".id = cast( auth_assignment.user_id as integer)')
            ->andWhere(['status' => User::STATUS_ACTIVE])
            ->andWhere(['!=', "item_name", "banned"])
            ->indexBy('id')
            ->asArray()
            ->column();
        $statusList = TaskStatus::find()
            ->select(['text', 'id'])
            ->andWhere(['deletedAt' => null])
            ->indexBy('id')
            ->asArray()
            ->column();
        $priorityList = TaskPriority::find()
            ->select(['name', 'id'])
            ->andWhere(['active' => true])
            ->indexBy('id')
            ->asArray()
            ->column();

        if ($model->load(Yii::$app->request->post())) {
            $model->creator_id = Yii::$app->user->getId();
            if (!Yii::$app->user->can('admin')) {
                $model->manager_id = $model->creator_id;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render($view, [
            'model' => $model,
            'userList' => $userList,
            'statusList' => $statusList,
            'priorityList' => $priorityList,

        ]);

    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
