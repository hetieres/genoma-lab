$(document).ready(function () {

    const sendPostRequest = async () => {
        try {
            let data = new FormData();
            let url = baseUrl + "api/admin/ajax/genetic-test-import";

            data.append('file', $('#file').prop('files')[0]);
            const resp = await axios.post(url, data);
            console.log(resp.data);
        } catch (err) {
            // Handle Error Here
            console.error(err);
        }
    };

    $('#save').click(function (event) {
        // let data = new FormData();

        if ($('#file').prop('files')[0]) {
            // data.append('file', $('#file').prop('files')[0]);
            // let url = baseUrl + "api/admin/ajax/genetic-test-import";
            // let message = "Atualizando com sucesso!";

            // $('#save').prop('disabled', true);
            // $('.form-group').addClass('d-none');
            // $('.load').removeClass('d-none');

            // axios.post(url, data).then(response => {
            //     let data = response.data;
            //     toastr.success(message);
            // }).catch(error => {
            //     console.log(error);
            // });

            sendPostRequest();

            console.log('aqui');

        } else {
            toastr.error('Selecione um arquivo.');
            $('#save').prop('disabled', false);
            $('.form-group').removeClass('d-none');
            $('.load').addClass('d-none');
        }

    });

    setInterval(function () {
        let data = new FormData();
        let url = baseUrl + "api/genetic-test-status-bar";

        axios.post(url, data).then(response => {
            let data = response.data;
            if (data.value == 'false') {
                $('#save').prop('disabled', false);
                $('.load').addClass('d-none');
                $('.form-group').removeClass('d-none');
            } else {
                $('#save').prop('disabled', true);
                $('.form-group').addClass('d-none');
                $('.load').removeClass('d-none');
                $('.load').find('label').eq(0).html(data.value);
            }
        }).catch(error => {
            console.log(error);
        });
    }, 333);

});