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

        if($('#unify_id').val() == ''){
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
        }

        if(save || $('#status_vehicle_id').val() == 3)
        {
            let data = new FormData();

            data.append('description', $('#description').val());
            data.append('country_id', $('#country_id').val());
            data.append('media_type_id', $('#media_type_id').val());
            data.append('status_vehicle_id', $('#status_vehicle_id').val());
            data.append('state', $('#state').val());
            data.append('city', $('#city').val());
            data.append('url', $('#url').val());
            data.append('import_id', $('#import_id').val());
            data.append('unify_id', $('#unify_id').val());
            data.append('big', $('#big').prop('checked'));
            data.append('limited_access', $('#limited_access').prop('checked'));
            data.append('id', $('#id').val());
            data.append('user_id', $('#user_id').val());

            let url = baseUrl + "api/admin/ajax/vehicle-save";
            let message = "Gravado com sucesso!";

            axios.post(url, data).then(response => {
                let data = response.data;

                $('.box-title').html(data.id + ' :: ' + data.description);
                $('#id').val(data.id);
                toastr.success(message);

            }).catch(error => {
                console.log('Error: ' + error.response.status + ' / ' + error.response.data);
            });
        }else{
            toastr.warning('Verifique campos obrigatórios');
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