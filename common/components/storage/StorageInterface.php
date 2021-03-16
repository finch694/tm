<?php


namespace common\components\storage;


use yii\web\UploadedFile;

interface StorageInterface
{
    public function saveUploadedFile(UploadedFile $file);

    public function getFile(string $filename);
}