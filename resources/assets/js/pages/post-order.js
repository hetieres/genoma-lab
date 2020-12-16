$(document).ready(function () {

    $("#sortable").sortable();

    $('#save').click(function (event) {
        $('#save').prop('disabled', true);
        let data = new FormData();
        let ids = [];
        $('input[name="ids"]').each(function () {
            ids.push($(this).val());
        });
        data.append('ids', ids);

        let url = baseUrl + "api/admin/ajax/post-order-save";
        let message = "Gravado com sucesso!";

        axios.post(url, data).then(response => {
            let data = response.data;
            toastr.success(message);
            $('#save').prop('disabled', false);
        }).catch(error => {
            console.log('Error: ' + error.response.status + ' / ' + error.response.data);
        });
    });


    $('.highlight_off').click(function () {
        console.log('aqui');
        let ele = $(this);
        event.preventDefault();

        var msg = "Remover dos destaques \n <strong>" + ele.parent().find('label').html() + "</strong>?";

        $('#modalPage').find('.modal-title').html('<i class=\"fa fa-fw fa-warning\"></i> Alerta!');
        $('#modalPage').find('.modal-body').html(msg);
        $('#modalPage').find('.modal-footer').html('<button type="submit" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="bnt-confirm" class="btn btn-danger pull-right">Sim</button>');

        $('#modalPage').modal();

        $('#bnt-confirm').click(function () {

            var data = new FormData();
            data.append('id', ele.parent().find('input[name="ids"]').eq(0).val());

            var url = baseUrl + "api/admin/ajax/post-highlight-off";
            var message = "Destaque removido!";

            axios.post(url, data).then(function (response) {
                // var data = response.data;
                toastr.error(message);
                ele.parent().remove();
            }).catch(function (error) {
                console.log('Error: ' + error.response.status + ' / ' + error.response.data);
            });

            $('#modalPage').modal('hide');
            $('#btn-submit').click();
        });
    });



});