$(document).ready(function () {

    $('#save').click(function (event) {
        $('#save').prop('disabled', true);
        let data = new FormData();

        if ($('#file').prop('files')[0]) {
            data.append('file', $('#file').prop('files')[0]);
            let url = baseUrl + "api/admin/ajax/genetic-test-import";
            let message = "Atualizado com sucesso!";

            $('.form-group').addClass('d-none');
            $('.load').removeClass('d-none');

            axios.post(url, data).then(response => {
                let data = response.data;
                toastr.success(message);
                $('#save').prop('disabled', false);
                $('.load').hide();
                $('.success').find('p').eq(0).html(data);
                $('.success').removeClass('d-none');
                $('.form-group').removeClass('d-none');
            }).catch(error => {
                console.log(error);
            });
        } else {
            toastr.error('Selecione um arquivo.');
            $('#save').prop('disabled', false);
            $('.form-group').removeClass('d-none');
            $('.load').addClass('d-none');
        }

    });

});