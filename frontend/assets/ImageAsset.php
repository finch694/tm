<?php


namespace frontend\assets;


use yii\web\AssetBundle;

class ImageAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets';
    public $css = [
        'image.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}