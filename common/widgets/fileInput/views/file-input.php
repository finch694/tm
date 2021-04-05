<?php

use common\widgets\fileInput\FileInputAsset;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var $this View
 * @var $model common\models\Task
 * @var $attribute string
 * @var $id
 */

$maxFileSize = Yii::$app->params['maxFileSize'];
$this->registerJs("
 var maxFiles = 10;

    var dataArray{$id} = [];

    var allFiles{$id} = new DataTransfer();
    
    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    function prepareToUpload() {
        var names = [];
        for (let i = 0; i < dataArray{$id}.length; i++) {
            names.push(dataArray{$id}[i].name);
        }
        var result = new DataTransfer();
        for (let i = 0; i < allFiles{$id}.files.length; i++) {
            if (names.includes(allFiles{$id}.files[i].name) && allFiles{$id}.files[i].size <= {$maxFileSize}) {
                result.items.add(allFiles{$id}.files[i]);
            }
        }
        $('#uploadbtn-{$id}')[0].files = result.files;
    }

    $('#uploadbtn-{$id}').on('change', function () {
        $('#upload-button-{$id} .error-summary').hide();
        var files{$id} = $(this)[0].files;
        for (var i = 0; i < files{$id}.length; i++)
            allFiles{$id}.items.add(files{$id}[i]);
        if (files{$id}.length <= maxFiles) {
            loadInView(files{$id});
        } else {
            alert(maxFiles + ' - maximum count of files to upload!');
            files{$id}.length = 0;
        }
    });

    function loadInView(files{$id}) {
        $('#new-files-{$id}').show();
        $.each(files{$id}, function (index, file) {
            if ((dataArray{$id}.length + files{$id}.length) <= maxFiles) {
                $('#upload-button-{$id}').css({'display': 'block'});
            } else {
                alert(maxFiles + ' - maximum count of files to upload!');
                return;
            }
             if (files{$id}[index].size <={$maxFileSize} ){
                var fileReader = new FileReader();
                fileReader.onload = (function (file) {
                return function (e) {
                    dataArray{$id}.push({name: file.name, value: this.result});
                    addImage((dataArray{$id}.length - 1));
                    prepareToUpload();
                };
                })(files{$id}[index]);
                fileReader.readAsDataURL(file);
            }else{
                $('#upload-button-{$id} .error-summary').html('Error! Files larger than '+formatBytes({$maxFileSize})+' are skipped').show();
                prepareToUpload();
            }

        });
        return false;
    }

    function addImage(ind) {
        if (ind < 0) {
            start = 0;
            end = dataArray{$id}.length;
        } else {
            start = ind;
            end = ind + 1;
        }
        if (dataArray{$id}.length == 0) {
            $('#upload-button-{$id}').hide();
            $('#new-files-{$id}').hide();
        } else if (dataArray{$id}.length == 1) {
            $('#upload-button-{$id} span').html(\"1 file to upload\");
        } else {
            $('#upload-button-{$id} span').html(dataArray{$id}.length + \" files to upload\");
        }
        for (i = start; i < end; i++) {
            if ($('#preview-block-{$id} > .image').length <= maxFiles) {
                $('#preview-block-{$id}').append(
                    '<div id=\"img-{$id}-' + i + '\" class=\"preview-image\" ' +
                    'title=\"'+ dataArray{$id}[i].name +'\"'+
                    'style=\"background: url(' + dataArray{$id}[i].value + '); background-size: contain;\"> ' +
                    '<a href=\"#\" id=\"drop-{$id}-' + i + '\" class=\"drop-button\">' +
                    '<i class=\"fa fa-remove\"></i>' +
                    '</a>' +
                    '</div>');
            }
        }
        return false;
    }

    $('#preview-block-{$id}').on('click', \"a[id^='drop']\", function (e) {
        e.preventDefault();
        var elid = $(this).attr('id');
        var temp = [];
        temp = elid.split('-');
        dataArray{$id}.splice(temp[2], 1);
        $('#preview-block-{$id} > .preview-image').remove();
        addImage(-1);
        prepareToUpload();
    });

    $(\"#preview-block-{$id}\").on(\"click\", \"a[id^='delete']\", function (e) {
        e.preventDefault();
        var elid = $(this).attr('id');
        var temp = [];
        temp = elid.split('-');
        $(this).remove();
        $('#img-{$id}-' + temp[2]).fadeTo(500, 0.2);
        var idToDelete = [];
        idToDelete.push(temp[2]);
        var old = [];
        if (old = $('#files-to-delete-{$id}').val()) {
            idToDelete.push(old);
        }
        $('#files-to-delete-{$id}').val(Array.from(idToDelete));
    });

    function restartFiles() {

        allFiles{$id} = new DataTransfer();
        dataArray{$id}.length = 0;
        prepareToUpload();
        $('#upload-button-{$id} .error-summary').hide();
        $('#upload-button-{$id}').hide();
        $('#preview-block-{$id} > .preview-image').remove();
        $('#new-files-{$id}').hide();
        return false;
    }
    $('#upload-button-{$id} .error-summary').hide();

    $('#new-files-{$id}').hide();

    $('.delete-{$id}').click(restartFiles);
");
FileInputAsset::register($this);
$modelName = explode("\\", $model::className());
$modelName = end($modelName);
$inputName = $modelName . '[' . str_replace('[]', '', $attribute) . '][]';
$inputNameToDelete = 'toDelete';
?>
<div id="<?= $id ?>">
    <input type="hidden" id="files-to-delete-<?= $id ?>" name="<?= $inputNameToDelete ?>"/>

    <div id="uploaded-holder-<?= $id ?>">
        <div id="preview-block-<?= $id ?>">
            <?php foreach ($model->attachmentFiles as $file) : ?>
                <div id="img-<?= $id ?>-<?= $file->id ?>" class="attachment-image" title="<?= $file->native_name ?>"
                     style="background: url(<?= Url::base(true) . Yii::$app->storage->getImgPreview($file->name) ?>);
                             background-size: contain;">
                    <a href="#" id="delete-<?= $id ?>-<?= $file->id ?>" class="delete-button">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div id="new-files-<?= $id ?>">
        <div id="upload-button-<?= $id ?>">
            <span>no files</span>
            <p class="error-summary"></p>
            <a href="#" class="delete-<?= $id ?>">Clear</a>
        </div>
    </div>


    <input type="file" id="uploadbtn-<?= $id ?>" name="<?= $inputName ?>" multiple/>
</div>
