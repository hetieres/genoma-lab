<script>
    import {toastrOptions} from "./constants/objects";

    export default {
        data: function () {
            return {
                baseUrl,
                admin:      'fapesp',
                ready:      false,
                total:      0,
                list:       [],
                news:       [],
                vehicles:   [],
                status:     [],
                categories: [],
                list2:      [],
                filters:    {page: 1, status: 0, vehicle: 0, category: 0, type_vehicle: 0, key: '', daterange: ''},
                errors:     []
            }
        },

        methods: {
            getNews: function () {
                this.ready     = false;
                let url        = baseUrl + "api/admin/ajax/get-news";

                axios.get(url, {
                    params: {
                        page:         this.filters.page,
                        status_id:    this.filters.status,
                        vehicle_id:   this.filters.vehicle,
                        category_id:  this.filters.category,
                        type_vehicle: this.filters.type_vehicle,
                        key:          this.filters.key,
                        daterange:    this.filters.daterange
                    }
                }).then(response => {
                    this.ready     = true;
                    this.list      = response.data;
                    this.news      = this.list.rs.data;
                    this.total     = this.list.rs.total;
                }).catch(error => {
                    console.log('Error: ' + error.response.status + ' / ' + error.response.data);
                });
            },

            navigate: function(ev, page){
                this.filters.key       = $('#key').val();
                this.filters.page      = page;
                if($('#daterange').val()){
                    this.filters.daterange = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD')
                                            + ','
                                            + $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }else{
                    this.filters.daterange = '';
                }
                this.getNews();
            },


            getAllComboBox: function () {
                let url = baseUrl + "api/admin/ajax/news/all-combo-box";

                axios.get(url).then(response => {
                    this.vehicles   = response.data.vehicles;
                    this.status     = response.data.status;
                    this.categories = response.data.categories;
                }).catch(error => {
                    console.log('Error: ' + error.response.status + ' / ' + error.response.data);
                });
            },

            _bindFilters: function () {
                $('#cb_vehicle, #cb_status, #cb_category, #cb_type_vehicle').change((e) => {
                    let $this          = e.target;
                    let item           = $($this).attr('id').replace('cb_', '');
                    this.filters[item] =  $($this).val();

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
                this.filters.vehicle = 0;
                $('#cb_vehicle').val(0);

                this.filters.type_vehicle = 0;
                $('#cb_type_vehicle').val(0);

                this.filters.status = 0;
                $('#cb_status').val(0);

                this.filters.category = 0;
                $('#cb_category').val(0);

                this.filters.key = '';
                $('#key').val('');

                this.daterange = '';
                $('#daterange').val('');

                $('#cb_vehicle, #cb_status, #cb_category, #cb_type_vehicle').trigger('change');

            },

            _bindRedirect: function (url) {
                url = baseUrl + this.admin + '/' + url;
                window.open(url, '_blank');
            },

            _bindEditMultiple: function () {
                let ids = [];
                let url = '';
                $(".table-responsive tbody tr td input:checked").each((i, el) => {
                    let id  = ($(el).parent().parent().parent().data('id') ? $(el).parent().parent().parent().data('id') : $(el).parent().parent().data('id'));
                    if(!ids.includes(id)){
                        ids.push(
                            ($(el).parent().parent().parent().data('id') ? $(el).parent().parent().parent().data('id') : $(el).parent().parent().data('id'))
                        );
                    }
                });
                if(ids.length > 1){
                    url = baseUrl + this.admin + '/noticias/multiplas/' + ids.join('-');
                }else if(ids.length == 1){
                    url = baseUrl + this.admin + '/noticias/' + ids[0];
                }
                window.open(url, '_blank');
            },

            _bindDelMultiple: function () {
                let ids    = [];
                let object = this;
                $(".table-responsive tbody tr td input:checked").each((i, el) => {
                    ids.push(
                        ($(el).parent().parent().parent().data('id') ? $(el).parent().parent().parent().data('id') : $(el).parent().parent().data('id'))
                    );
                });

                ids = ids.join('-');

                let msg = "Confirma, exclusão da(s) matéria(s) <strong>" + ids + "</strong>?";


                $('#modalPage').find('.modal-title').html('<i class=\"fa fa-fw fa-warning\"></i> Alerta!');
                $('#modalPage').find('.modal-body').html(msg);
                $('#modalPage').find('.modal-footer').html('<button type="submit" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="bnt-confirm" class="btn btn-danger pull-right">Sim</button>');

                $('#modalPage').modal();

                $('#bnt-confirm').click(function () {

                    let data = new FormData();
                    data.append('id', ids);

                    let url = baseUrl + "api/admin/ajax/news-delete";
                    let message = "Deletado's com sucesso!";

                    axios.post(url, data).then(response => {
                        let data = response.data;
                        toastr.success(message);
                        object.getNews();
                    }).catch(error => {
                        console.log('Error: ' + error.response.status + ' / ' + error.response.data);
                    });

                    $('#modalPage').modal('hide');
                });
            },

            _openMultiple: function () {
                let open;
                $(".table-responsive tbody tr td input:checked").each((i, el) => {
                       let url = baseUrl + this.admin + '/noticias/' + ($(el).parent().parent().parent().data('id') ? $(el).parent().parent().parent().data('id') : $(el).parent().parent().data('id'));
                       window.open(url, '_blank');
                });
            },

            _delete: function(id){
                console.log('aqui');
                let object = this;
                let msg    = "Confirma, exclusão da matéria <strong>" + id + "</strong>?";


                $('#modalPage').find('.modal-title').html('<i class=\"fa fa-fw fa-warning\"></i> Alerta!');
                $('#modalPage').find('.modal-body').html(msg);
                $('#modalPage').find('.modal-footer').html('<button type="submit" class="btn btn-default" data-dismiss="modal">Cancelar</button><button type="button" id="bnt-confirm" class="btn btn-danger pull-right">Sim</button>');

                $('#modalPage').modal();

                $('#bnt-confirm').click(function () {

                    let data = new FormData();
                    data.append('id', id);

                    let url = baseUrl + "api/admin/ajax/news-delete";
                    let message = "Deletado com sucesso!";

                    axios.post(url, data).then(response => {
                        let data = response.data;
                        toastr.success(message);
                        object.getNews();
                    }).catch(error => {
                        console.log('Error: ' + error.response.status + ' / ' + error.response.data);
                    });

                    $('#modalPage').modal('hide');

                });

            },

            _getIds: function() {
                $(".table-responsive tbody").on("click", "> tr", function(e) {

                    let id   = $(this).data('id'),
                        cbox = $(this).find('input[type=checkbox]');

                    // cbox.prop("checked", !cbox.prop("checked"));
                    cbox.prop('checked', !cbox.prop("checked")).iCheck('update'); // Ver se atrapalha, em alguns momentos ele não adiciona ou remove se houver click muito rápido

                    // IDs multipla ediçao
                    let ids = [];
                    $(this).parent().find("input:checked").each((i, el) => {
                        ids.push(
                            ($(el).parent().parent().parent().data('id') ? $(el).parent().parent().parent().data('id') : $(el).parent().parent().data('id'))
                        );
                    });

                    if(ids.length >= 1) {
                        $('.btn-multiple').prop("disabled",false);
                    } else {
                        $('.btn-multiple').prop("disabled",true);
                    }
                });
            },

            _getCookie: function(name) {
                let pattern = RegExp(name + "=.[^;]*"),
                    matched = document.cookie.match(pattern);

                if (matched) {
                    var cookie = matched[0].split('=');
                    return decodeURIComponent(cookie[1]).replace(/\+/g, ' ');
                }

                return '';
            }


        },



        mounted: function () {
            // this.filters.vehicle   = (this._getCookie('n_vehicle_id')      || this.filters.vehicle);
            // this.filters.category  = (this._getCookie('n_category_id')     || this.filters.category);
            // this.filters.status    = (this._getCookie('n_news_status_id')  || this.filters.status);
            // this.filters.page      = (this._getCookie('n_page')            || this.filters.page);
            // this.filters.key       = (this._getCookie('n_key')             || this.filters.key);
            // this.filters.daterange = (this._getCookie('n_daterange')       || this.filters.daterange);

            this.getNews();
            this.getAllComboBox();
            this._bindFilters();
            this._getIds();
        },

        updated: () => {
            $('.table-responsive tbody > tr > td input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_square-red cbox',
                increaseArea: '20%' // optional
            });

            $("input[type='checkbox']").on('ifChanged', function () {
                    // IDs multipla ediçao
                    let ids = [];
                    $(".table-responsive tbody tr td input:checked").each((i, el) => {
                        ids.push(
                            ($(el).parent().parent().parent().data('id') ? $(el).parent().parent().parent().data('id') : $(el).parent().parent().data('id'))
                        );
                    });

                    if(ids.length >= 1) {
                        $('.btn-multiple').prop("disabled",false);
                    } else {
                        $('.btn-multiple').prop("disabled",true);
                    }
                });

            $('.btn-multiple').prop("disabled",true);
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
                <div class="form-group col-md-3">
                    <label for="cb_type_vehicle">Tipo Veículo</label>
                    <select class="form-control select2" name="cb_type_vehicle" id="cb_type_vehicle">
                            <option value="0">Todos</option>
                            <option value="1">Nacionais</option>
                            <option value="2">Internacionais</option>
                            <option value="3">Grande Imprensa</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Status</label>
                    <select class="form-control select2" name="cb_status" id="cb_status">
                        <option value="0">Todos</option>
                        <option v-for="status in status" :key="status.id" :value="status.id" :selected="filters.status == status.id">{{ status.description }}</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Categoria</label>
                    <select class="form-control select2" name="cb_category" id="cb_category">
                        <option value="0">Todos</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id" :selected="filters.category == category.id">{{ category.description }}</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Período</label>
                    <input type="text" class="form-control" id="daterange" name="daterange" :value="filters.daterange">
                </div>
            </div>

            <div class="box-body">
                <div class="form-group col-md-6">
                    <label>Veículo</label>
                    <select class="form-control select2" name="cb_vehicle" id="cb_vehicle" >
                        <option value="0">Todos</option>
                        <option v-for="vehicle in vehicles" :key="vehicle.id" :value="vehicle.id" :selected="filters.vehicle == vehicle.id">{{ vehicle.description }}</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="key">Palavra chave</label>
                    <input type="text" class="form-control" id="key" name="key" placeholder="Palavra chave" :value="filters.key">
                </div>
            </div>

            <div class="box-footer">
                <div class="pull-right">
                    <button class="btn btn-default" v-on:click="_bindClearFilters">Limpar</button>
                    <button class="btn btn-info pull-right" v-on:click="navigate($event, 1)" id="btn-submit">Filtrar</button>
                </div>
                <div class="pull-left">
                    <button class="btn btn-success" v-on:click="_bindRedirect('noticias/novo')">Nova Notícia</button>
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

    <div v-if="ready==true && news.length > 0">

        <div class="box">
            <!-- <div class="box-header">
                <h3 class="box-title">Noticías</h3>
            </div> -->
            <!-- /.box-header -->
            <div class="box-header clearfix">
                <div class="pull-left">
                    <button class="btn bg-purple btn-multiple" v-on:click="_bindEditMultiple()" disabled>Multipla edição</button>
                    <button class="btn btn-danger btn-multiple" v-on:click="_bindDelMultiple()" disabled>Excluir</button>
                    <button class="btn btn-warning btn-multiple" v-on:click="_openMultiple()" disabled>Abrir</button>
                    <button class="btn bg-olive" v-on:click="getNews()">Atualizar</button>
                </div>
                <div class="pull-right">
                    <ul class="pagination pagination-sm no-margin pull-right">
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
                            <th></th>
                            <th>Código</th>
                            <th>Título</th>
                            <th>Veículo</th>
                            <th>Categoria</th>
                            <th>data</th>
                            <th>Status</th>
                            <!-- <th>Atualizado</th> -->
                            <th>Ações</th>
                        </tr>
                        <tr v-for="news in news" :key="news.id" :data-id="news.id">
                            <td><input type="checkbox"></td>
                            <td>{{ news.id }}</td>
                            <td>{{ news.title }}</td>
                            <td>
                                {{ (news.vehicle && news.vehicle !== null && news.vehicle !== undefined ? news.vehicle.description : '') }} |
                                {{ (news.mediaType && news.mediaType !== null && news.mediaType !== undefined ? news.mediaType.description : '') }} <br>
                                {{ news.from }}
                            </td>
                            <td>{{ news.category ? news.category.description : '' }}</td>
                            <td>{{ news.date }}</td>
                            <td>{{ news.status.description }}</td>
                            <!-- <td>{{ news.dt_update }}</td> -->
                            <td>
                                <a href="javascript:;" class="edit col-xs-3" v-on:click="_bindRedirect('noticias/' + news.id)"><i class="fa fa-pencil"></i></a>
                                <a href="javascript:;" class="edit col-xs-3" v-on:click="_bindRedirect('veiculos/' + news.vehicle.id)"><i class="fa fa-fw fa-automobile"></i></a>
                                <a href="javascript:;" class="edit col-xs-3" v-on:click="_delete(news.id)"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pull-left">
                    <button class="btn bg-purple btn-multiple" v-on:click="_bindEditMultiple()" disabled>Multipla edição</button>
                    <button class="btn btn-danger btn-multiple" v-on:click="_bindDelMultiple()" disabled>Excluir</button>
                    <button class="btn btn-warning btn-multiple" v-on:click="_openMultiple()" disabled>Abrir</button>
                    <button class="btn bg-olive" v-on:click="getNews()">Atualizar</button>
                </div>
                <div class="pull-right">
                    <ul class="pagination pagination-sm no-margin pull-right">
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
