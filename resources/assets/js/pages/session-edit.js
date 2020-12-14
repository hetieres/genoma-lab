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

        let save = true;

        $('.required').each(function () {
            if ($(this).val()) {
                $(this).parent().parent().removeClass('has-error');
                $(this).parent().parent().find('.select2-selection.select2-selection--single').css('border', '1px solid #d2d6de');
            } else {
                save = false;
                $(this).parent().parent().addClass('has-error');
                $(this).parent().parent().find('.select2-selection.select2-selection--single').css('border', '1px solid #dd4b39');
            }
        });

        if (save) {
            let data = new FormData();

            data.append('description', $('#description').val());
            data.append('type_list_id', $('#type_list_id').val());
            data.append('ids', $('#ids').val());
            data.append('url', $('#url').val());
            data.append('id', $('#id').val());
            data.append('user_id', $('#user_id').val());

            let url = baseUrl + "api/admin/ajax/session-save";
            let message = "Gravado com sucesso!";

            axios.post(url, data).then(response => {
                let data = response.data;
                toastr.success(message);
                setTimeout(() => {
                    document.location.reload(true);
                }, 2000);

            }).catch(error => {
                console.log('Error: ' + error.response.status + ' / ' + error.response.data);
            });
        } else {
            toastr.warning('Verifique campos obrigatórios');
        }


    });

    $('#ids').select2({
        tags: true,
        createTag: function (params) {
            var numberPattern = /\d+/g;
            return {
                id: params.term.match(numberPattern).join(''),
                text: params.term.match(numberPattern).join('')
            }

        }
    });

    $('#type_list_id').change(function () {
        if ($('#type_list_id').val() == 3) {
            $('.d-ids').show();
        } else {
            $('.d-ids').hide();
        }
    });

    $('#type_list_id').change();


});