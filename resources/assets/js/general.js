$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('.select2').select2();
    $('.select2-container').css('width', '100%');

    $('#modalPage').on('hidden.bs.modal', function (e) {
        var modal   = $('div#modalPage');
        modal.attr('aria-labelledby', '');
        modal.removeClass('type-danger');
        modal.removeClass('type-primary');
        modal.removeClass('type-success');
        modal.removeClass('type-warning');
        modal.find('h4.modal-title').html('');
        modal.find('div.modal-body').html('');
    });

    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red',
            increaseArea: '20%' // optional
        });
    });
});