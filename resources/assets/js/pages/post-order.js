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


});