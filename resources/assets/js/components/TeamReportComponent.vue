<script>
    import {toastrOptions} from "./constants/objects";

    export default {
        data: function () {
            return {
                baseUrl,
                admin:      'fapesp',
                ready:      false,
                list:       [],
                list2:      [],
                list3:      [],
                filters:    {order: 'DESC', group: 1, daterange: ''},
                errors:     []
            }
        },

        methods: {
            getNews: function () {
                this.ready     = false;
                let url        = baseUrl + "api/admin/ajax/report/team";

                axios.get(url, {
                    params: {
                        order:     this.filters.order,
                        group:     this.filters.group,
                        daterange: this.filters.daterange
                    }
                }).then(response => {
                    this.ready     = true;
                    this.list      = response.data.news_by_member;
                    this.list2     = response.data.news_balance;
                    this.list3     = response.data.vehicles_by_member;
                }).catch(error => {
                    console.log('Error: ' + error.response.status + ' / ' + error.response.data);
                });
            },

            navigate: function(ev, page){
                this.filters.key       = $('#key').val();
                if($('#daterange').val()){
                    this.filters.daterange = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD')
                                            + ','
                                            + $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }else{
                    this.filters.daterange = '';
                }
                this.getNews();
            },

            _bindFilters: function () {
                $('#cb_order, #cb_group').change((e) => {
                    let $this          = e.target;
                    let item           = $($this).attr('id').replace('cb_', '');
                    this.filters[item] =  $($this).val();

                    $('#btn-submit').click();
                });

                $('#btn-submit').on('click', () => {
                    if(this.ready) this.navigate(null, 1);
                });

            },


            _bindClearFilters: function () {
                this.filters.group = 1;
                $('#cb_group').val(1);

                this.filters.order = 'DESC';
                $('#cb_order').val('DESC');

                this.daterange = '';
                $('#daterange').val('');

                $('#cb_order, #cb_group').trigger('change');

            },

            _bindDownload: function (report) {
                var url = baseUrl + this.admin + '/relatorio/equipe/download?';
                url +='report=' + report;
                url +='&order=' + this.filters.order;
                url +='&group=' + this.filters.group;
                url +='&daterange=' + this.filters.daterange;
                window.location.href = url;
            }
        },

        mounted: function () {
            this.getNews();
            this._bindFilters();
        }
    }
</script>

<template>
    <div class="col-xs-12">

    <div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Filtros</h3>
            </div>

            <div class="box-body">
                <div class="form-group col-md-4">
                    <label>Período</label>
                    <input type="text" class="form-control" id="daterange" name="daterange" :value="filters.daterange">
                </div>
                <div class="form-group col-md-4">
                    <label for="cb_group">Agrupamento </label>
                    <select class="form-control select2" name="cb_group" id="cb_group" :value="filters.group">
                            <option value="0">Diário</option>
                            <option value="1">Mensal</option>
                            <option value="2">Anual</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="cb_order">Ordenação </label>
                    <select class="form-control select2" name="cb_order" id="cb_order" :value="filters.order">
                            <option value="ASC">Crescente</option>
                            <option value="DESC">Decrescente</option>
                    </select>
                </div>
            </div>

            <div class="box-footer">
                <div class="pull-right">
                    <button class="btn btn-default" v-on:click="_bindClearFilters">Limpar</button>
                    <button class="btn btn-info pull-right" v-on:click="navigate($event, 1)" id="btn-submit">Filtrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="text-red text-center load" v-if="ready==false">
        <img class="loading" :src="baseUrl + 'assets/img/loading.svg'"  style="width: 100%; height: 200px;"/>
    </div>

    <div v-if="ready==true && list.length > 0">
        <div class="box">
            <div class="box-header clearfix">
                <div class="pull-left">
                    <h3 class="box-title">Matérias editadas X equipe</h3>
                </div>
                <div class="pull-right">
                    <button class="btn bg-maroon" v-on:click="_bindDownload(1)" >Download</button>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>Data</th>
                            <th>Jussara</th>
                            <th>Mônica Luri</th>
                            <th>Mônica Lopes</th>
                            <th>Sheyla</th>
                            <th>Total</th>
                        </tr>
                        <tr v-for="obj in list" :key="obj.date" :data-id="obj.date">
                            <td>{{ obj.date }}</td>
                            <td>{{ obj.jussara }}</td>
                            <td>{{ obj.monica_luri }}</td>
                            <td>{{ obj.monica_lopes }}</td>
                            <td>{{ obj.sheyla }}</td>
                            <td>{{ obj.total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pull-right">
                    <button class="btn bg-maroon" v-on:click="_bindDownload(1)" >Download</button>
                </div>
            </div>
        </div>
    </div>

    <div v-if="ready==true && list2.length > 0">
        <div class="box">
            <div class="box-header clearfix">
                <div class="pull-left">
                    <h3 class="box-title">Balanço de matérias</h3>
                </div>
                <div class="pull-right">
                    <button class="btn bg-purple" v-on:click="_bindDownload(2)" >Download</button>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>Data</th>
                            <th>Total Clipadora</th>
                            <th>Total Manual</th>
                            <th>Classificadas</th>
                            <th>Não Classificadas</th>
                            <th>URL's Total</th>
                            <th>URL's Inseridas</th>
                            <th>URL's Não Inseridas</th>
                            <th>Total Pedentes</th>
                        </tr>
                        <tr v-for="obj in list2" :key="obj.date" :data-id="obj.date">
                            <td>{{ obj.date }}</td>
                            <td>{{ obj.total_clipping }}</td>
                            <td>{{ obj.total_manual }}</td>
                            <td>{{ obj.indexed }}</td>
                            <td>{{ obj.no_indexed }}</td>
                            <td>{{ obj.url_total }}</td>
                            <td>{{ obj.url_indexed }}</td>
                            <td>{{ parseInt(obj.url_total) - parseInt(obj.url_indexed) }}</td>
                            <td>{{ parseInt(obj.url_total) - parseInt(obj.url_indexed) + parseInt(obj.no_indexed) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pull-right">
                    <button class="btn bg-purple" v-on:click="_bindDownload(2)" >Download</button>
                </div>
            </div>
        </div>
    </div>

    <div v-if="ready==true && list3.length > 0">
        <div class="box">
            <div class="box-header clearfix">
                <div class="pull-left">
                    <h3 class="box-title">Veículos X equipe</h3>
                </div>
                <div class="pull-right">
                    <button class="btn bg-green" v-on:click="_bindDownload(3)" >Download</button>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>Data</th>
                            <th>Total</th>
                            <th>Total Verificado</th>
                            <th>Jussara</th>
                            <th>Mônica Luri</th>
                            <th>Mônica Lopes</th>
                            <th>Sheyla</th>
                            <th>Sistema</th>
                        </tr>
                        <tr v-for="obj in list3" :key="obj.date" :data-id="obj.date">
                            <td>{{ obj.date }}</td>
                            <td>{{ obj.total }}</td>
                            <td>{{ obj.total_indexed }}</td>
                            <td>{{ obj.jussara }}</td>
                            <td>{{ obj.monica_luri }}</td>
                            <td>{{ obj.monica_lopes }}</td>
                            <td>{{ obj.sheyla }}</td>
                            <td>{{ obj.system }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pull-right">
                    <button class="btn bg-green" v-on:click="_bindDownload(3)" >Download</button>
                </div>
            </div>
        </div>
    </div>

    </div>
</template>

<style scoped=""></style>
