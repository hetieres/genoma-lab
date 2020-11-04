$(document).ready(function () {
    $('input[name="daterange"]').daterangepicker({
        autoUpdateInput: false,
        opens: 'left',
        ranges: {
            'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
            'Este Mês': [moment().startOf('month'), moment().endOf('month')],
            'Mês Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Limpar",
            "fromLabel": "De",
            "toLabel": "Para",
            "customRangeLabel": "Personalizado",
            "weekLabel": "S",
            "daysOfWeek": [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab" ],
            "monthNames": [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro" ],
            "firstDay": 1
        },
    }, function(start, end, label) {
        console.log("Uma nova seleção de data foi feita: " + start.format('DD-MM-YYYY') + ' à ' + end.format('DD-MM-YYYY'));
    }).on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        $('#btn-submit').click();
    }).on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        $('#btn-submit').click();
    });
});