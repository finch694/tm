<?php


namespace common\widgets\fileInput;

use yii\web\AssetBundle;

class FileInputAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
    }


    public $css = [
        'fileInput.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}