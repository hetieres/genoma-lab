var search = {
    init: function() {
        this.bindDaterange();
        this.bindFilters();
        this.bindOrder();
        this.bindSearch();
        this.scrollResults();
    },

    bindDaterange: function() {
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
            $('#searchOrder > select#orderning').change();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('#searchOrder > select#orderning').change();
        });
    },

    bindFilters: function() {
        $('a.media, a.year, a.tag, a.category').on('click', event => {
            event.preventDefault();
            $(event.target).toggleClass('active');
            this._filter();
        });

        $('a.allArea').on('click', event => {
            $(event.target).parent().parent().find('a.tag').addClass('active');
            this._filter();
        });
    },

    bindOrder: function() {
        $('#searchOrder > select#orderning').on('change', event => {
            event.preventDefault();
            this._filter();
        });
    },

    bindSearch: function() {
        let form = $("#searchBox");
        form.find('input#searchInput').keypress(event =>  {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13') this._filter();
        });

        form.find('button#searchBtn').on('click', event => {
            event.preventDefault();
            this._filter();
        });

        form.find('button#searchClear').on('click', event => {
            event.preventDefault();
            $('#searchBox input#searchInput').val("");
            this._filter();
        });

        form.find('')
    },

    scrollResults: function() {
        let element  = $('main.internal h2.infoSearch'),
            elOffset = element.offset(),
            elHeight = element.innerHeight(),
            newEl    = element.clone().addClass('fixed');

        $(window).on('scroll', document, function() {
            let scrollTop = $(this).scrollTop();

            if (scrollTop>=(elOffset.top + elHeight) && $('main.internal h2.infoSearch.fixed').length === 0) {
                $('main.internal .searchLine').after(newEl);
                $('main.internal h2.infoSearch.fixed').animate({top: 0}, 300);
            } else if (scrollTop<(elOffset.top + elHeight) && $('main.internal h2.infoSearch.fixed').length > 0) {
                $('main.internal h2.infoSearch.fixed').animate({top: "-50px"}, 150, function () { $(this).remove(); });
            }
        });
    },

    _filter: function() {
        let url      = baseUrl + 'pesquisa?k=' + $('#searchBox input#searchInput').val(),
            media    = '',
            year     = '',
            tag      = '',
            category = '';

        // Media
        $('a.media.active').each((i, el) => media = media + $(el).attr('href') + '-');
        if (media!=='') url = url + '&m=' + media.substring(0, media.length - 1);

        // Categocry
        $('a.category.active').each((i, el) => category = category + $(el).attr('href') + '-');
        if (category!=='') url = url + '&c=' + category.substring(0, category.length - 1);

        // Years
        $('a.year.active').each((i, el) => year = year + $(el).attr('href') + '-');
        if (year!=='') url = url + '&y=' + year.substring(0, year.length - 1);

        // Tags
        $('a.tag.active').each((i, el) => tag = tag + $(el).attr('href') + '-');
        if (tag!=='') url = url + '&t=' + tag.substring(0, tag.length - 1);

        //periodo
        if($('input[name="daterange"]').val().length){
            url = url +'&p='
                        + $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD')
                        + ','
                        + $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
        }


        // Orders
        if ($('#searchOrder > select#orderning').val() > 1) url = url + '&o=' + $('#searchOrder > select#orderning').val();

        // Redirect to Search
        window.location = url;
    }
};

$(document).ready(function() {
    search.init();
});