$(function () {
    $(document).on('click', '.mod', function () {
            let data;
            if ($(this).parent('tr').length) {
                data = $(this).parent('tr').data();
            } else {
                data = $(this).data();
            }
            let mod = $(this).attr('class');
            if (mod.indexOf('user')) {
                mod = 'user';
            } else if (mod.indexOf('priority')) {
                mod = 'priority';
            } else if (mod.indexOf('status')) {
                mod = 'status';
            }
            $('#modal-change').modal('show').find('.modal-body').load('/task/modal?id=' + data.key + '&mod=' + mod);
        }
    );
    $(document).on('mouseenter', '.mod', function () {
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
    $(document).on('mouseenter', '.truncate', function () {

        if ($(this)[0].scrollWidth > $(this)[0].clientWidth || $(this).hasClass('untruncate'))
            $(this).css('cursor', 'pointer').css('background-color', '#D2D6DE');
    });
    $(document).on('mouseleave', '.truncate', function () {
        $(this).css('cursor', 'auto').css('background-color', '');
    });
})
