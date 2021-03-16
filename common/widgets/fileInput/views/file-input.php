<?php

/**
 * @var $model common\models\Task
 * @var $attribute string
 */

use common\widgets\fileInput\FileInputAsset;
use yii\helpers\Url;

FileInputAsset::register($this);
$modelName = explode("\\", $model::className());
$modelName = end($modelName);
$inputName = $modelName . '[' . str_replace('[]', '', $attribute) . '][]';
//$inputNameToDelete = $modelName . '[toDelete]';
$inputNameToDelete = 'toDelete';
?>

<input type="hidden" id="files-to-delete" name="<?= $inputNameToDelete ?>"/>

<div id="uploaded-holder">
    <div id="preview-block">
        <?php foreach ($model->attachmentFiles as $file) : ?>
            <div id="img-<?= $file->id ?>" class="attachment-image"
                 style="background: url(<?= Url::base(true). Yii::$app->storage->getFile($file->name) ?>);
                         background-size: contain;">
                <a href="#" id="delete-<?= $file->id ?>" class="delete-button">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div id="new-files">
    <div id="upload-button">
        <span>no files</span>
        <a href="#" class="delete">Clear</a>
    </div>
</div>


<input type="file" id="uploadbtn" name="<?= $inputName ?>" multiple/>
