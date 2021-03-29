$(function () {
//todo refactor
    var maxFiles = 10;

    var defaultUploadBtn = $(defaultUploadBtnID);

    var dataArray = [];

    var allFiles = new DataTransfer();

    function prepareToUpload() {
        var names = [];
        for (let i = 0; i < dataArray.length; i++) {
            names.push(dataArray[i].name);
        }
        var result = new DataTransfer();
        for (let i = 0; i < allFiles.files.length; i++) {
            if (names.includes(allFiles.files[i].name)) {
                result.items.add(allFiles.files[i]);
            }
        }
        defaultUploadBtn[0].files = result.files;
    }

    defaultUploadBtn.on('change', function () {
        var files = $(this)[0].files;
        for (var i = 0; i < files.length; i++)
            allFiles.items.add(files[i]);
        if (files.length <= maxFiles) {
            loadInView(files);
        } else {
            alert('Вы не можете загружать больше ' + maxFiles + ' изображений!');
            files.length = 0;
        }
    });

    function loadInView(files) {
        $('#new-files').show();
        $.each(files, function (index, file) {
            if ((dataArray.length + files.length) <= maxFiles) {
                $('#upload-button').css({'display': 'block'});
            } else {
                alert(maxFiles + ' - maximum count of files to upload!');
                return;
            }
            var fileReader = new FileReader();
            fileReader.onload = (function (file) {
                return function (e) {
                    dataArray.push({name: file.name, value: this.result});
                    addImage((dataArray.length - 1));
                    prepareToUpload();
                };
            })(files[index]);
            fileReader.readAsDataURL(file);
            // }
        });
        return false;
    }

    function addImage(ind) {
        if (ind < 0) {
            start = 0;
            end = dataArray.length;
        } else {
            start = ind;
            end = ind + 1;
        }
        if (dataArray.length == 0) {
            $('#upload-button').hide();
            $('#new-files').hide();
        } else if (dataArray.length == 1) {
            $('#upload-button span').html("1 file to upload");
        } else {
            $('#upload-button span').html(dataArray.length + " files to upload");
        }
        for (i = start; i < end; i++) {
            if ($('#preview-block > .image').length <= maxFiles) {
                $('#preview-block').append(
                    '<div id="img-' + i + '" class="preview-image" ' +
                    'style="background: url(' + dataArray[i].value + '); background-size: contain;"> ' +
                    '<a href="#" id="drop-' + i + '" class="drop-button">' +
                    '<i class="fa fa-remove"></i>' +
                    '</a>' +
                    '</div>');
            }
        }
        return false;
    }

    $("#preview-block").on("click", "a[id^='drop']", function (e) {
        e.preventDefault();
        var elid = $(this).attr('id');
        var temp = [];
        temp = elid.split('-');
        dataArray.splice(temp[1], 1);
        $('#preview-block > .preview-image').remove();
        addImage(-1);
        prepareToUpload();

    });

    $("#preview-block").on("click", "a[id^='delete']", function (e) {
        e.preventDefault();
        var elid = $(this).attr('id');
        var temp = [];
        temp = elid.split('-');
        dataArray.splice(temp[1], 1);
        $(this).remove();
        $('#img-' + temp[1]).fadeTo(500, 0.2);
        var idToDelete = [];
        idToDelete.push(temp[1]);
        var old = [];
        if (old = $('#files-to-delete').val()) {
            idToDelete.push(old);
        }
        $('#files-to-delete').val(Array.from(idToDelete));
    });

    function restartFiles() {

        allFiles = new DataTransfer();
        dataArray.length = 0;
        prepareToUpload();
        $('#upload-button').hide();
        $('#preview-block > .preview-image').remove();
        $('#new-files').hide();
        return false;
    }

    $('#new-files').hide();

    $('.delete').click(restartFiles);
});