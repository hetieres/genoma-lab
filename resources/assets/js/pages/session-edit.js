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

    CKEDITOR.replace('aside', {
        height: 350
    });

    $("#sortable").sortable();

    $('.colorize').colorpicker({
        format: 'hex'
    });

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
            data.append('url', $('#url').val());
            data.append('color', $('#color').val());
            data.append('aside', CKEDITOR.instances['aside'].getData());
            data.append('id', $('#id').val());
            data.append('user_id', $('#user_id').val());

            //ids relacionados
            let ids = [];
            $('input[name="ids"]').each(function () {
                ids.push($(this).val());
            });
            data.append('ids', ids);

            let url = baseUrl + "api/admin/ajax/session-save";
            let message = "Gravado com sucesso!";

            axios.post(url, data).then(response => {
                let data = response.data;
                toastr.success(message);
                setTimeout(() => {
                    // document.location.reload(true);
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

    $('#add_id').keyup(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            $('.btn-rel-add').click();
        }
        $('#label_rel').html('');
        if ($('#add_id').val()) {
            setTimeout(() => {
                let url = baseUrl + "api/admin/ajax/post-load";
                let data = new FormData();
                data.append('id', $('#add_id').val());

                axios.post(url, data).then(response => {
                    let data = response.data;
                    if (data) {
                        $('#label_rel').html(data.title);
                    }
                });
            }, 200);
        }
    });

    $('.btn-rel-add').click(function (event) {
        event.preventDefault();
        $('#add_id').val($('#add_id').val().trim());
        let add_id = $('#add_id').val();
        let save = true;

        $('input[name="ids"]').each(function () {
            if ($(this).val() == add_id) {
                toastr.error('ID já relacionado!');
                save = false;
            }
        });

        if (Math.floor(add_id) != add_id || !$.isNumeric(add_id)) {
            toastr.error('ID fora do padrão');
            save = false;
        }

        if (save) {
            let url = baseUrl + "api/admin/ajax/post-load";
            let data = new FormData();
            data.append('id', add_id);
            data.append('html', true);

            axios.post(url, data).then(response => {
                let data = response.data;
                if (data) {
                    data = data + $('#sortable').html();
                    $('#sortable').html(data);
                    $('#add_id').val('');
                    $('#label_rel').html('');
                    $("#sortable").sortable();
                    toastr.success('Matéria relacionada!');
                    delRelBind();
                } else {
                    toastr.error('ID não existe na base de dados!');
                }
            }).catch(error => {
                console.log('Error: ' + error.response.status + ' / ' + error.response.data);
            });
        }
    });


    function delRelBind() {
        $(".btn-rel-del").unbind("click");
        $('.btn-rel-del').bind("click", function (event) {
            event.preventDefault();
            $(this).parent().remove();
        });
    }

    delRelBind();


});