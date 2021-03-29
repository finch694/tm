<?php
/* @var $model common\models\Task */


use yii\helpers\Html;
use yii\helpers\Url;

foreach ($model->attachmentFiles as $file) {

    echo Html::tag('div',
        Html::a(
            Html::tag('i', '', ['class' => 'glyphicon glyphicon-save lead', 'style' => 'margin-left:5px']),
            "/task/download?id=" . $file->id, ['data-pjax' => 0]),
        ['style' => 'background:url(' .
            Url::base(true). Yii::$app->storage->getImgPreview($file->name) . ');',
            'class' => 'img-max',
            'title'=>$file->native_name,
        ]);
}
