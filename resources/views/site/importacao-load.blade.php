@extends('layouts.site')
@section('extra-script')
<script>
    $(document).ready(function () {
        $('.preloader').eq(0).append('<div style="position: relative; top: 83px; right: 55px;"><label id="label" style="color: #000;">0%</label></div>');
        setInterval(function () {

            $('#preloader-active').show();

            let data = new FormData();
            let url = baseUrl + "api/genetic-test-status-bar";


            axios.post(url, data).then(response => {
                let data = response.data;
                if (data.value == 'false') {
                    location.reload(true);
                } else {
                    $('#label').eq(0).html(data.value);
                }
            }).catch(error => {
                console.log(error);
            });
        }, 333);
    });
</script>

@endsection

