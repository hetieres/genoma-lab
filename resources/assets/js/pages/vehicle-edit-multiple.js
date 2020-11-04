$(document).ready(function () {


    toastr.options = {
        "closeButton": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
        "showDuration": "300",
        "hideDuration": "300",
        "timeOut": "5000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    $('#save').click(function (event) {

        event.preventDefault();

        if($("#unify_id").val() == ''){
            toastr.error('Selecione veículo válido para unificar');
        }else{

                    let msg = "Confirma, unificar todos veiculos selecionados?<br>";

                    msg += $("#unify_id").val() + ' :: ' +  $("#unify_id option:selected").text();


                    $('#modalPage').find('.modal-title').html('Unificar');
                    $('#modalPage').find('.modal-body').html(msg);
                    $('#modalPage').find('.modal-footer').html('<button type="submit" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="bnt-confirm" class="btn btn-danger pull-right">Sim</button>');

                    $('#modalPage').modal();

                    $('#bnt-confirm').click(function () {
                        let data = new FormData();

                        data.append('unify_id', $('#unify_id').val());
                        data.append('ids', $('#ids').val());
                        data.append('user_id', $('#user_id').val());


                        let url = baseUrl + "api/admin/ajax/vehicle-multiple-save";
                        let message = "Gravados com sucesso!";

                        axios.post(url, data).then(response => {

                            toastr.success(message);

                        }).catch(error => {
                            console.log('Error: ' + error.response.status + ' / ' + error.response.data);
                        });
                        $('#modalPage').modal('hide');
                    });

        }
    });

});