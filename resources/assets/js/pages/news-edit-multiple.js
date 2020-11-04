$(document).ready(function () {

    position = 0;

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
        "closeButton":       false,
        "progressBar":       true,
        "positionClass":     "toast-bottom-right",
        "preventDuplicates": true,
        "showDuration":      "300",
        "hideDuration":      "300",
        "timeOut":           "5000",
        "extendedTimeOut":   "3000",
        "showEasing":        "swing",
        "hideEasing":        "linear",
        "showMethod":        "fadeIn",
        "hideMethod":        "fadeOut"
    };

    $("input[type='checkbox']").on('ifChanged', function (e) {
         $('.d-extra').toggleClass('hidden');
    });

    $('#save').click(function (event) {

        event.preventDefault();

        let msg = "Confirma, multipla edição das matérias?<br>";

        msg += $("#ids").val();


        $('#modalPage').find('.modal-title').html('Alerta');
        $('#modalPage').find('.modal-body').html(msg);
        $('#modalPage').find('.modal-footer').html('<button type="submit" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="bnt-confirm" class="btn btn-danger pull-right">Sim</button>');

        $('#modalPage').modal();

        $('#bnt-confirm').click(function () {

            let data = new FormData();
            data.append('title', $('#title').val());
            data.append('summary', $('#summary').val());
            data.append('text', CKEDITOR.instances['text'].getData());
            data.append('news_status_id', $('#news_status_id').val());
            data.append('category_id', $('#category_id').val());
            data.append('citation_type_id', $('#citation_type_id').val());
            data.append('author', $('#author').val());
            data.append('url_fapesp', $('#url_fapesp').val());
            data.append('tags', $('#tags').val());
            data.append('ids', $('#ids').val());
            data.append('user_id', $('#user_id').val());
            data.append('number_researcher', $("#number_researcher").val());

            let number_process = [];
            if($("#number_process").val()){
                number_process = $("#number_process").val();
                for(i = 0; i < number_process.length; i++){
                    number_process[i] = number_process[i].replace(/[^\d]+/g,'');
                }
            }
            data.append('number_process', number_process);


            let url = baseUrl + "api/admin/ajax/news-multiple-save";
            let message = "Gravado com sucesso!";

            axios.post(url, data).then(response => {
                let data = response.data;
                toastr.success(message);
            }).catch(error => {
                console.log('Error: ' + error.response.status + ' / ' + error.response.data);
            });

            $('#modalPage').modal('hide');

        });
    });

    $('#next').click(function () {
        position++;
        if(position == json_news.length - 1){
            $('#next').prop('disabled', true);
        }
        $('#prev').prop('disabled', false);
        $('#remove').html('Remover da Edição :: ' + json_news[position]['id']);
        CKEDITOR.instances['text'].setData(json_news[position]['text']);
    });

    $('#prev').click(function () {
        position--;
        if(position == 0){
            $('#prev').prop('disabled', true);
        }
        $('#next').prop('disabled', false);
        $('#remove').html('Remover da Edição :: ' + json_news[position]['id']);
        CKEDITOR.instances['text'].setData(json_news[position]['text']);
    });

    $('#remove').click(function () {
        $('#title_' + json_news[position]['id']).remove();
        let ids = [];
        let aux = [];
        for(i = 0; i < json_news.length; i++){
            if(json_news[i]['id'] != json_news[position]['id']){
                aux.push(json_news[i]);
                ids.push(json_news[i]['id']);
            }
        }
        json_news = aux;
        $('#ids').val(ids.join('-'));
        //volta a pesquisa caso só restar um notícia
        if(json_news.length == 1){
            window.location = baseUrl + 'admin/noticias';
        }
        //define posição
        if(position > 0){
            position--;
        }

        //habilita botoes
        if(position == 0){
            $('#prev').prop('disabled', true);
            $('#next').prop('disabled', false);
        }else if(position == (json_news.length - 1)){
            $('#prev').prop('disabled', false);
            $('#next').prop('disabled', true);
        }else{
            $('#prev').prop('disabled', false);
            $('#next').prop('disabled', false);
        }

        $('#remove').html('Remover da Edição :: ' + json_news[position]['id']);
        CKEDITOR.instances['text'].setData(json_news[position]['text']);

    });

    $('#number_process').select2({
        tags: true,
        createTag: function (params) {

            var number = params.term.replace(/[^\d]+/g,'');

            if ((number.length != 8 && number.length != 10) || (number == 0)){
                return null;
            }else{
                var dig = number.charAt(number.length-1);
                var num = number.substring(number.length - 6, number.length - 1);
                var ano = number.substring(number.length - 8, number.length - 6);
                var sum = (ano.charAt(0)*2) + (ano.charAt(1)*3) + (num.charAt(0)*8) + (num.charAt(1)*4) + (num.charAt(2)*5) + (num.charAt(3)*6) + (num.charAt(4)*7);
                var mod = sum % 11;
                if(mod == 10)
                    mod = 0;
                if(dig != mod)
                    return null;
            }

            return {
                id: params.term,
                text: params.term
            }
        }
    }).on('select2:open', function (e) {
        $('.select2-container--open .select2-dropdown--below').css('display','none');
    });

    $('.btn-copy').click(function(){
        let txt = '';
        for(i = 0; i < json_news.length; i++){
            txt = txt + json_news[i].vehicle.description + ' - ' + json_news[i].date + ' ' + baseUrl + json_news[i].id  + " \n";
        }

        var $temp = $("<textarea>");
        $("body").append($temp);
        $temp.val(txt).select();
        document.execCommand("copy");
        $temp.remove();
        toastr.success('Link\'s copiado!');
    });

    $('#number_researcher').select2({
        tags: true,
        createTag: function (params) {

            params.term = params.term.replace(/[^\d]+/g,'');

            if(params.term == "")
                return null;

            return {
                id: params.term,
                text: params.term
            }
        }
    }).on('select2:open', function (e) {
        $('.select2-container--open .select2-dropdown--below').css('display','none');
    });

});