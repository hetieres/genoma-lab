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

    function createChart(container, json){
      // Create the chart
      Highcharts.chart(container, {
        chart: {
          type: 'column'
        },
        title: {
          text: json['title']
        },
        subtitle: {
          text: json['filter']
        },
        xAxis: {
          type: 'category'
        },
        yAxis: {
          title: {
            text: 'Total de Notícias'
          }

        },
        legend: {
          enabled: false
        },
        credits: {
          "enabled": true,
          text: 'Fapesp na Mídia',
          href: baseUrl
        },
        plotOptions: {
          series: {
            borderWidth: 0,
            dataLabels: {
              enabled: true,
              format: '{point.y:.0f}'
            }
          }
        },

        tooltip: {
          headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b><br/>'
        },

        "series": [
          {
            "name": json['type'],
            "colorByPoint": true,
            "data": json['data']
          }
        ],
      });
    }

    function mountTable(tbody, json){
        let tr = '';
        for(i = 0; i < json['data'].length; i++)
        {
            if(tbody == '.table4'){
                if(json['data'][i]['country_id'] == 1){
                    json['data'][i]['country'] = json['data'][i]['country'] + ' | ' +
                                                 json['data'][i]['state']   + ' | ' +
                                                 json['data'][i]['city'] ;
                }
                tr += '<tr>' +
                            '<td>' + json['data'][i]['id']            + '</td>' +
                            '<td>' + json['data'][i]['description']   + '</td>' +
                            '<td>' + json['data'][i]['country']       + '</td>' +
                            '<td>' + json['data'][i]['media_type']    + '</td>' +
                            '<td>' + json['data'][i]['url']           + '</td>' +
                            '<td>' + json['data'][i]['total']         + '</td>' +
                        '</tr>';
            }else{
                tr += '<tr>' +
                            '<td>' + (i+1) + '.</td>' +
                            '<td>' + json['data'][i]['title'] + '</td>';

                if(json['data'][i]['url_fapesp'])
                    tr +=   '<td>' + json['data'][i]['url_fapesp'] + '</td>';

                tr +=       '<td>' + json['data'][i]['total'] + '</td>' +
                        '</tr>'
            }
        }

        $(tbody).html(tr);
        $(tbody).parent().parent().parent().find('.filter').html(json['filter']);

        let div  = $(tbody).parent().parent().parent();
        let bnt  = $(div).parent().find('.btn-download');
        let name = $(div).find('h3').html() + '.png';
        setTimeout(() => {
            html2canvas(div, {
            onrendered: function (canvas) {
                var imgageData = canvas.toDataURL("image/png");
                // Now browser starts downloading it instead of just showing it
                var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                $(bnt).attr("download", name).attr("href", newData);
                }
            });
        }, 500);
    }

    function mountTableList(tbody, json){
        let tr = '';
        for(i = 0; i < json['data'].length; i++)
        {
            if(tbody == '.table3'){
                tr += '<tr>' +
                            '<td>' + json['data'][i]['id']                     + '.</td>' +
                            '<td>' + json['data'][i]['title']                  + '</td>'  +
                            '<td>' + json['data'][i]['vehicle']['description'] + ' | '    + json['data'][i]['mediaType']['description'] + '</td>'  +
                            '<td>' + json['data'][i]['from']                   + '</td>'  +
                            '<td>' + json['data'][i]['url']                    + '</td>'  +
                            '<td>' + json['data'][i]['date']                   + '</td>'  +
                        '</tr>';
            }else if(tbody == '.table4'){
                tr += '<tr>' +
                            '<td>' + json['data'][i]['id']            + '</td>' +
                            '<td>' + json['data'][i]['description']   + '</td>' +
                            '<td>' + json['data'][i]['media_type']    + '</td>' +
                            '<td>' + json['data'][i]['url']           + '</td>' +
                            '<td>' + json['data'][i]['total']         + '</td>' +
                        '</tr>';
            }
        }

        $(tbody).html(tr);
        $(tbody).parent().parent().parent().find('.filter').html(json['filter']);

        let btn = $(tbody).parent().parent().parent().parent().find('.btn-download').eq(0);
        let url = baseUrl + 'fapesp/relatorio/noticias/download?' + json['url'];

        btn.html('Download (' + json['total'] + ' notícias)');
        btn.attr("href", url);

        $('.help-block').html('Total filtrado :: ' + json['total']);

    }

    function createChartPeriod(json){
        Highcharts.chart('container3', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Repercussão '
        },
        subtitle: {
            text: 'Mês X Período' + json['filter']
        },
        xAxis: {
            categories: json['months'],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
            text: 'Repercussão'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        credits: {
            "enabled": true,
            text: 'Fapesp na Mídia',
            href: baseUrl
          },
        plotOptions: {
            column: {
            pointPadding: 0.2,
            borderWidth: 0
            }
        },
        series: json['series']
        });
    }


    $('.btn-filter').click(function (){

        //load
        $('.load').removeClass('d-none');
        $('.done').addClass('d-none');

        let data = new FormData();
        data.append('news_status_id', $('#cb_status').val());
        data.append('media_type_id', $('#cb_media').val());
        data.append('category_id', $('#cb_category').val());
        data.append('vehicle_id', $('#cb_vehicle').val());
        data.append('citation_type_id', $('#cb_citation').val());
        data.append('vehicle_type', $('#cb_type_vehicle').val());
        data.append('limit', $('#cb_limit').val());
        data.append('key', $('#key').val());
        //periodo
        if($('input[name="daterange"]').val().length)
        {
          data.append('period', $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD') + ',' + $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD'));
        }

        let url = baseUrl + "api/admin/ajax/report/news";

        axios.post(url, data).then(response => {

            $('.done').removeClass('d-none');
            $('.load').addClass('d-none');

            createChart('container1', response.data[0]);
            createChart('container2', response.data[1]);
            mountTable('.table1', response.data[2]);
            mountTable('.table2', response.data[3]);
            mountTableList('.table3', response.data[4]);
            createChartPeriod(response.data[5]);
            mountTable('.table4', response.data[6]);


        }).catch(error => {
            console.log(error.response);
        });


    });

    $(".btn-clear").click( function(){
        $('#cb_status').val(0).trigger('change');
        $('#cb_media').val(0).trigger('change');
        $('#cb_category').val(0).trigger('change');
        $('#cb_vehicle').val(0).trigger('change');
        $('#cb_type_vehicle').val(0).trigger('change');
        $('#cb_limit').val('15').trigger('change');
        $('input[name="daterange"]').val('');

        $('.btn-filter').click();
    });

    setTimeout(() => {
        $('.btn-filter').click();
    }, 500);

});