
        $(document).ready(function () {

            for(i = 0; i < json.length && i < 3; i++){
                Highcharts.chart('container' + i, {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: json[i]['title']
                        },
                        plotOptions: {
                            pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false,
                            },
                            showInLegend: true
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:15px">{point.key}: </span>',
                            pointFormat: '<b>{point.y:.0f} </b>',
                            footerFormat: '',
                            shared: true,
                            useHTML: true
                        },
                        credits: {
                            "enabled": true,
                            text: 'Fapesp na Mídia',
                            href: baseUrl
                        },
                        series: [{
                            name: json[i]['type'],
                            colorByPoint: true,
                            data: json[i]['data']
                        }]
                    });

            }

            Highcharts.chart('container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Repercussão '
                },
                subtitle: {
                    text: 'Mês X Período'
                },
                xAxis: {
                    categories: json[3]['months'],
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
                series: json[3]['series']
                });

        });