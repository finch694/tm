$(function () {
    $(document).on('click', '.mod', function () {
            let data;
            if ($(this).parent('tr').length) {
                data = $(this).parent('tr').data();
            } else {
                data = $(this).data();
            }
            let mod = $(this).attr('class');
            if (mod.indexOf('user') + 1) {
                mod = 'user';
            } else if (mod.indexOf('priority') + 1) {
                mod = 'priority';
            } else if (mod.indexOf('status') + 1) {
                mod = 'status';
            } else if (mod.indexOf('manager') + 1) {
                mod = 'manager';
            }
            let sub =  $(location).attr('href').indexOf('admin') + 1 ? '/admin' : '';
            $('#modal-change-sm').modal('show').find('.modal-body').load(sub + '/task/modal?id=' + data.key + '&mod=' + mod);
        }
    );
    $(document).on('click', '.file', function () {
            let data;
            if ($(this).parent('tr').length) {
                data = $(this).parent('tr').data();
            } else {
                data = $(this).data();
            }
            let sub = $(location).attr('href').indexOf('admin') + 1 ? '/admin' : '';

            $('#modal-change-md').modal('show').find('.modal-body').load(sub + '/task/modal-image?id=' + data.key);
        }
    );
    $(document).on('click', '.file a', function (e) {
            e.stopPropagation();
        }
    );
    $(document).on('mouseenter', '.mod ', function () {
        $(this).css('cursor', 'pointer').css('box-shadow', 'inset 0 ' + ($(this).height() + 20) + 'px 0  #D2D6DE');
    });
    $(document).on('mouseleave', '.mod', function () {
        $(this).css('cursor', 'auto').css('box-shadow', '');
    });
    $(document).on("click", ".truncate", function () {
        if ($(this)[0].scrollWidth > $(this)[0].clientWidth)
            $(this).addClass("untruncate");
    });
    $(document).on("click", ".untruncate", function () {
        $(this).removeClass("untruncate");
    });
    $(document).on('mouseenter', '.truncate, .file', function () {

        if ($(this)[0].scrollWidth > $(this)[0].clientWidth || $(this).hasClass('untruncate') || $(this).hasClass('file'))
            $(this).css('cursor', 'pointer').css('background-color', '#D2D6DE');
    });
    $(document).on('mouseleave', '.truncate, .file', function () {
        $(this).css('cursor', 'auto').css('background-color', '');
    });
})
