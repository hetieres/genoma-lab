$(document).ready(function () {


    $('.date').datepicker({
        language: 'pt-BR',
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $('.fa.fa-calendar').click(function () {
        $(this).parent().parent().find('.date').show();
    });

    CKEDITOR.replace('text', {
        height: 500
    });

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
        //campos requiridos
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
            data.append('title', $('#title').val());
            data.append('summary', $('#summary').val());
            data.append('text', CKEDITOR.instances['text'].getData());
            data.append('dt_publication', $('#dt_publication').val());
            data.append('active', $('#active').is(':checked'));
            data.append('highlight', $('#highlight').is(':checked'));
            data.append('caption_image', $('#caption_image').val());
            data.append('session_id', $('#session_id').val());
            data.append('id', $('#id').val());
            data.append('user_id', $('#user_id').val());
            data.append('keywords', $("#keywords").val());
            data.append('id_youtube', $("#id_youtube").val());
            data.append('href', $("#href").val());
            data.append('live', $("#live").val());
            

            if ($('#image').prop('files').length) {
                data.append('image', $('#image').prop('files')[0]);
            }

            let url = baseUrl + "api/admin/ajax/post-save";
            

            let message = "Gravado com sucesso!";

            axios.post(url, data).then(response => {
                let data = response.data;
                //error
                if (data.errors) {
                    for (let i = 0; i < data.errors.length; i++) {
                        toastr.error(data.errors[i]);
                    }
                }
                //atualiza header titulo da materia
                if (data.id) {
                    $('.box-title').html(data.id + ' :: ' + data.title);
                    CKEDITOR.instances['text'].setData(data.text);
                    toastr.success(message);
                }
                //redireciona para edição da nova materia
                if (data.id && $('#id').val() != data.id) {
                    window.location.href = baseUrl + 'fapesp/materia/' + data.id;
                }

            }).catch(error => {
                console.log(error);
            });
            

        } else {
            toastr.warning('Verifique campos obrigatórios');
        }

    });

    $('#image').change(function () {
        if ($('#image').prop('files').length) {
            let url = baseUrl + "api/admin/ajax/post-view-image";
            let data = new FormData();
            data.append('image', $('#image').prop('files')[0]);

            axios.post(url, data).then(response => {
                let img = response.data;
                if (img !== '') {
                    $('.img-view').find('img').attr('src', img);
                    $('.img-view').removeClass('d-none');
                    $('#flag-img').val(1);
                }
            }).catch(error => {
                console.log('Error: ' + error.response.status + ' / ' + error.response.data);
            });

        }
    });

    $('#del-image').click(function () {

        event.preventDefault();

        $('#modalPage').find('.modal-title').html('<i class=\"fa fa-fw fa-warning\"></i> Alerta!');
        $('#modalPage').find('.modal-body').html('Confirma, exclusão da imagem?');
        $('#modalPage').find('.modal-footer').html('<button type="submit" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="bnt-del-image" class="btn btn-danger pull-right">Sim</button>');

        $('#modalPage').modal();

        $('#bnt-del-image').click(function () {

            let url = baseUrl + "api/admin/ajax/post-destroy-image";
            let message = "Imagem apagada!";

            let data = new FormData();
            data.append('id', $('#id').val());

            axios.post(url, data).then(response => {
                let data = response.data;
                $('.img-view').addClass('d-none');
                $('#flag-img').val(0);
                toastr.success(message);
            }).catch(error => {
                console.log('Error: ' + error.response.status + ' / ' + error.response.data);
            });

            $('#modalPage').modal('hide');
        });

    });

    $('#del').click(function () {

        event.preventDefault();

        let msg = "Confirma, exclusão da matéria <strong>" + $('#id').val() + "</strong>?";


        $('#modalPage').find('.modal-title').html('<i class=\"fa fa-fw fa-warning\"></i> Alerta!');
        $('#modalPage').find('.modal-body').html(msg);
        $('#modalPage').find('.modal-footer').html('<button type="submit" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="bnt-confirm" class="btn btn-danger pull-right">Sim</button>');

        $('#modalPage').modal();

        $('#bnt-confirm').click(function () {

            let data = new FormData();
            data.append('id', $('#id').val());

            let url = baseUrl + "api/admin/ajax/post-del";
            let message = "Deletado com sucesso!";

            axios.post(url, data).then(response => {
                let data = response.data;
                toastr.error(message);
                setTimeout(() => {
                    window.location.href = baseUrl + 'fapesp/materia';
                }, 300);
            }).catch(error => {
                console.log('Error: ' + error.response.status + ' / ' + error.response.data);
            });

            $('#modalPage').modal('hide');
            $('#btn-submit').click();

        });

    });

    $('.btn-copy').click(function () {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($('#url_copy').val()).select();
        document.execCommand("copy");
        $temp.remove();
        toastr.success('Link copiado!');
    });

    $('#keywords').select2({
        tags: true
    });

    $('#id_youtube').select2({
        tags: true,
        createTag: function (params) {
            var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            var match = params.term.match(regExp);
            if ($('#id_youtube').val().length) {
                return null;
            }
            if (match && match[2].length == 11) {
                var img = '<img src = "https://img.youtube.com/vi/' + match[2] + '/0.jpg" >';
                $(".youtube-preview").html(img);
                return {
                    id: match[2],
                    text: match[2]
                }
            } else {
                if (params.term.length == 11) {
                    var img = '<img src = "https://img.youtube.com/vi/' + params.term + '/0.jpg" >';
                    $(".youtube-preview").html(img);
                    return {
                        id: params.term,
                        text: params.term
                    }
                } else {
                    $(".youtube-preview").html('');
                    return null;
                }
            }
        }
    });

    $('#id_youtube').on("change", function () {
        if ($('#id_youtube').val().length == 0) {
            $(".youtube-preview").html('');
        }
    });

    $("#session_id").on("change", function () {
        if ($("#session_id").val() == 4) {
            $(".video").show();
            $(".no-video").hide();
        } else {
            $(".video").hide();
            $(".no-video").show();
        }

        if ($("#session_id").val() == 5) {
            $(".no-content").hide();
        } else {
            $(".no-content").show();
        }
    });

    $("#session_id").change();


});