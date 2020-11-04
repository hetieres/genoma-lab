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
        //campos requiridos
        $('.required').each(function (){
            if($(this).val()){
                $(this).parent().parent().removeClass('has-error');
                $(this).parent().parent().find('.select2-selection.select2-selection--single').css('border', '1px solid #d2d6de');
            }else{
                save = false;
                $(this).parent().parent().addClass('has-error');
                $(this).parent().parent().find('.select2-selection.select2-selection--single').css('border', '1px solid #dd4b39');
            }
        });

        if(save)
        {
            $('.load').removeClass('d-none');
            $('.box-body').addClass('d-none');

            let data = new FormData();

            data.append('url', $('#url').val());
            data.append('topic', $('#topic').val());
            data.append('url_type_id', $('#url_type_id').val());

            let url = baseUrl + "api/admin/ajax/link-save";

            axios.post(url, data).then(response => {
                let data = response.data;
                toastr.info(data.pending + '/' + data.register + ' (pendentes/inseridas)');
                toastr.success('Gravado com sucesso!');

                $('.load').addClass('d-none');
                $('.box-body').removeClass('d-none');
                $('#url').val('');
            }).catch(error => {
                console.log('Error: ' + error.response.status + ' / ' + error.response.data);
            });
        }else{
            toastr.warning('Preencha o campo!');
        }


    });

    $('#country_id').change(function (){
        $('#cb_country').trigger('change');
        if($('#country_id').val() != 1){
            $('.d-state, .d-city').hide();
        }else{
            $('.d-state, .d-city').show();
        }
    });

    $('#country_id').change();


});