<?php
/* @var $model common\models\Task */


use yii\helpers\Html;

foreach ($model->attachmentFiles as $file) {

    echo Html::tag('div',
        Html::a(
            Html::tag('i', '', ['class' => 'glyphicon glyphicon-save lead', 'style' => 'margin-left:5px']),
            "/task/download?id=" . $file->id, ['data-pjax' => 0]),
        ['style' => 'background:url(' .
            'http://tmback.test'. Yii::$app->storage->getFile($file->name) . ');',  //todo remake url
            'class' => 'img-max'
        ]);
}
