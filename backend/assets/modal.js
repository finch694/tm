$(function () {
    $(document).on('click', '.mod', function () {
        let data = $(this).parent('tr').data();
        let mod = $(this).attr('class');
        mod = (mod.replace('mod', '')).trim();
        $('#modal-change').modal('show').find('.modal-body').load('/task/modal?id=' + data.key + '&mod=' + mod);
    });
    $(document).on('mouseenter','.mod',function () {
        $(this).css('cursor', 'pointer').css('box-shadow', 'inset 0 '+($(this).height()+20)+'px 0  #D2D6DE');
    });
    $(document).on('mouseleave','.mod',function () {
            $(this).css('cursor', 'auto').css('box-shadow', '');
    });
})
