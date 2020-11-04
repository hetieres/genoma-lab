<script>
    import {toastrOptions} from "./constants/objects";

    export default {
        props: ['types'],
        data: function () {
            return {
                baseUrl,
                admin:      'fapesp',
                ready:      true,
                total:      0,
                list:       [],
                urls:       [],
                filters:    {page: 1, key: '', register: '0', daterange: '', type: '', order: '0'},
                errors:     []
            }
        },

        methods: {
            getUrls: function () {
                let url = baseUrl + "api/admin/ajax/link-list";
                this.ready    = false;
                axios.get(url, {
                    params: {
                        page:      this.filters.page,
                        register:  this.filters.register,
                        daterange: this.filters.daterange,
                        type:      this.filters.type,
                        key:       this.filters.key,
                        order:     this.filters.order,
                        }
                }).then(response => {
                    this.ready = true;
                    this.list  = response.data;
                    this.urls  = this.list.rs.data;
                    this.total = this.list.rs.total;
                }).catch(error => {
                    console.log('Error: ' + error.response.status + ' / ' + error.response.data);
                });
            },

            navigate: function(ev, page) {
                this.filters.key      = $('#key').val();
                this.filters.register = $('#cb_register').val();
                this.filters.type     = $('#cb_type').val();
                this.filters.type     = $('#cb_type').val();
                this.filters.page     = page;

                if($('#daterange').val()){
                    this.filters.daterange = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD')
                                            + ','
                                            + $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }else{
                    this.filters.daterange = '';
                }

                this.getUrls(page);
            },

            _bindFilters: function () {
                $('#cb_register,#cb_type,#cb_order').change((e) => {
                    let $this = e.target;
                    let item = $($this).attr('id').replace('cb_', '');
                    this.filters[item]  = $($this).val();

                    $('#btn-submit').click();
                });

                $('#key').on('keypress', (e) => {
                    if(e.which == 13) $('#btn-submit').click();
                });

                $('#btn-submit').on('click', () => {
                    if(this.ready) this.navigate(null, 1);
                });
            },

            _bindClearFilters: function () {
                this.filters.register = '';
                $('#cb_register').val('');
                this.filters.type = '';
                $('#cb_type').val('');
                this.filters.key = '';
                $('#key').val('');
                this.filters.daterange = '';
                $('#daterange').val('');

                $('#cb_register, #cb_type').trigger('change');
            },

            _bindRedirect: function (url) {
                url = baseUrl + this.admin + '/' + url;
                window.open(url, '_blank');
            },

            download: function (url) {
                url = baseUrl + this.admin + '/links/download?register=' + this.filters.register + '&key=' + this.filters.key + '&type=' + this.filters.type + '&daterange=' + this.filters.daterange;
                window.open(url);
            },

            _delete: function(id){
                let object = this;
                let msg    = "Confirma, exclusão da URL? <br><strong>" + id + "</strong>";


                $('#modalPage').find('.modal-title').html('<i class=\"fa fa-fw fa-warning\"></i> Alerta!');
                $('#modalPage').find('.modal-body').html(msg);
                $('#modalPage').find('.modal-footer').html('<button type="submit" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="bnt-confirm" class="btn btn-danger pull-right">Sim</button>');

                $('#modalPage').modal();

                $('#bnt-confirm').click(function () {

                    let data = new FormData();
                    data.append('url', id);

                    let url = baseUrl + "api/admin/ajax/link-del";
                    let message = "Deletado com sucesso!";

                    axios.post(url, data).then(response => {
                        let data = response.data;
                        toastr.success(message);
                        object.getUrls();
                    }).catch(error => {
                        console.log('Error: ' + error.response.status + ' / ' + error.response.data);
                    });

                    $('#modalPage').modal('hide');

                });

            },

        },

        mounted: function () {
            this._bindFilters();
            this.getUrls();
            setTimeout(() => {
                $('#daterange').daterangepicker({
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
                        $("#daterange").val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                        $('#btn-submit').click();
                    }).on('cancel.daterangepicker', function(ev, picker) {
                        $("#daterange").val('');
                        $('#btn-submit').click();
                    });
            }, 300);
        }
    }
</script>

<template>
    <div class="col-xs-12">

    <div >
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Filtros</h3>
            </div>
            <div class="box-body">
                <div class="form-group col-md-2">
                    <label for="cb_register">Status</label>
                    <select class="form-control select2" name="cb_register" id="cb_register" :value="filters.register">
                            <option value="">Todos</option>
                            <option value="0">Pendente</option>
                            <option value="1">Inserida</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Pendência</label>
                    <select class="form-control select2" name="cb_type" id="cb_type">
                        <option value="">Todos</option>
                        <option v-for="type in this.types" :key="type.id" :selected="type.id == filters.type" :value="type.id" v-html="type.description"></option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="key">Palavra chave</label>
                    <input type="text" class="form-control" id="key" name="key" placeholder="Palavra chave">
                </div>
                <div class="form-group col-md-2">
                    <label>Período</label>
                    <input type="text" class="form-control" id="daterange" name="daterange" :value="filters.daterange">
                </div>
                <div class="form-group col-md-2">
                    <label for="cb_register">Ordenação</label>
                    <select class="form-control select2" name="cb_order" id="cb_order" :value="filters.order">
                            <option value="0">Data Decrescente</option>
                            <option value="1">URL </option>
                            <option value="2">Tema | Url</option>
                    </select>
                </div>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button class="btn btn-default" v-on:click="_bindClearFilters">Limpar</button>
                    <button class="btn btn-info pull-right" id="btn-submit">Filtrar</button>
                </div>
                <div class="pull-left">
                    <button class="btn btn-success" v-on:click="_bindRedirect('links')">Adicionar URL's</button>
                </div>
            </div>
            <div class="box-footer">
                <p class="help-block"> Total filtrado :: {{  total }}</p>
            </div>
        </div>
    </div>

    <div class="text-red text-center load" v-if="ready==false">
        <img class="loading" :src="baseUrl + 'assets/img/loading.svg'"  style="width: 100%; height: 200px;"/>
    </div>

    <div v-if="ready==true && urls.length > 0" >

        <div class="box">
            <div class="box-header">
                <div class="pull-left">
                    <button class="btn btn-info btn-multiple" v-on:click="download()">Download</button>
                </div>
                <div class="pull-right">
                    <ul v-if="ready==true" class="pagination pagination-sm no-margin pull-right">
                        <li><a href="javascript:;" v-on:click="navigate($event, 1)">«</a></li>
                        <li><a href="javascript:;" v-on:click="navigate($event, list.rs.current_page - 1)">‹</a></li>
                        <li v-for="page in list.rangePages" :key="page" :class="{active: list.rs.current_page == page}">
                            <a href="javascript:;" v-on:click="navigate($event, page)">{{ page }}</a>
                        </li>
                        <li><a href="javascript:;" v-on:click="navigate($event, list.rs.current_page + 1)">›</a></li>
                        <li><a href="javascript:;" v-on:click="navigate($event, list.rs.last_page)">»</a></li>
                    </ul>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>URL</th>
                            <th>Tema</th>
                            <th>Pendência</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                        <tr v-for="url in urls" :key="url.url" >
                            <td style="overflow-wrap: break-word; max-width: 500px;"><a v-bind:href="url.url" target="_blank">{{ url.url }}</a></td>
                            <td>{{ url.topic }}</td>
                            <td>{{ url.type.description }}</td>
                            <td>{{ url.register ? 'Inserido' : 'Pendente' }}</td>
                            <td>{{ url.date }}</td>
                            <td>
                                <a href="javascript:;" class="edit col-xs-3" v-on:click="_delete(url.url)"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pull-left">
                    <button class="btn btn-info btn-multiple" v-on:click="download()">Download</button>
                </div>
                <div class="pull-right">
                    <ul v-if="ready==true" class="pagination pagination-sm no-margin pull-right">
                        <li><a href="javascript:;" v-on:click="navigate($event, 1)">«</a></li>
                        <li><a href="javascript:;" v-on:click="navigate($event, list.rs.current_page - 1)">‹</a></li>
                        <li v-for="page in list.rangePages" :key="page" :class="{active: list.rs.current_page == page}">
                            <a href="javascript:;" v-on:click="navigate($event, page)">{{ page }}</a>
                        </li>
                        <li><a href="javascript:;" v-on:click="navigate($event, list.rs.current_page + 1)">›</a></li>
                        <li><a href="javascript:;" v-on:click="navigate($event, list.rs.last_page)">»</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    </div>
</template>

<style scoped=""></style>
