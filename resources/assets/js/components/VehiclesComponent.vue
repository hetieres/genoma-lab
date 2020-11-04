<script>
    import {toastrOptions} from "./constants/objects";

    export default {
        data: function () {
            return {
                baseUrl,
                admin:      'fapesp',
                ready:      true,
                total:      0,
                list:       [],
                vehicles:   [],
                countries:  [],
                mediaTypes: [],
                status:     [],
                list2:      [],
                filters:    {page: 1, status: 0, country: '0', media: 0, key: ''},
                errors:     []
            }
        },

        methods: {
            getVehicles: function () {
                let url = baseUrl + "api/admin/ajax/vehicle-get";
                this.ready    = false;
                axios.get(url, {
                    params: {
                        page:              this.filters.page,
                        status_vehicle_id: this.filters.status,
                        country_id:        this.filters.country,
                        media_type_id:     this.filters.media,
                        key:               this.filters.key,
                    }
                }).then(response => {
                    this.ready     = true;
                    this.list      = response.data;
                    this.vehicles  = this.list.rs.data;
                    this.total     = this.list.rs.total;
                }).catch(error => {
                    console.log('Error: ' + error.response.status + ' / ' + error.response.data);
                });
            },

            navigate: function(ev, page) {
                this.filters.key     = $('#key').val();
                this.filters.media   = $('#cb_media').val();
                this.filters.status  = $('#cb_status').val();
                this.filters.country = $('#cb_country').val();
                this.filters.page    = page;
                this.getVehicles(page);
            },

            getAllComboBox: function () {
                let url = baseUrl + "api/admin/ajax/vehicle/all-combo-box";

                axios.get(url).then(response => {
                    this.countries  = response.data.countries;
                    this.status     = response.data.status;
                    this.mediaTypes = response.data.mediaTypes;
                }).catch(error => {
                    console.log('Error: ' + error.response.status + ' / ' + error.response.data);
                });
            },

            testEvent: function() {
                console.log("Testando");
            },

            _bindFilters: function () {
                $('#cb_country, #cb_status, #cb_media').change((e) => {
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
                this.filters.status  = 0;
                $('#cb_country').val(0);

                this.filters.country = 0;
                $('#cb_status').val(0);

                this.filters.media = 0;
                $('#cb_media').val(0);

                this.filters.key = '';
                $('#key').val('');

                $('#cb_country, #cb_status, #cb_media').trigger('change');
            },

            _bindRedirect: function (url) {
                url = baseUrl + this.admin + '/' + url;
                window.open(url, '_blank');
            },

            _bindEditMultiple: function () {
                let ids = [];
                let url = '';
                $(".table-responsive tbody tr td input:checked").each((i, el) => {
                    ids.push(
                        ($(el).parent().parent().parent().data('id') ? $(el).parent().parent().parent().data('id') : $(el).parent().parent().data('id'))
                    );
                });
                url = baseUrl + this.admin + '/veiculos/multiplos/' + ids.join('-');
                window.open(url, '_blank');
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
                    return decodeURI(cookie[1]).replace(/\+/g, ' ');
                }

                return '';
            }
        },

        mounted: function () {
            // this.filters.status  = (this._getCookie('v_status_vehicle_id') || this.filters.status);
            // this.filters.country = (this._getCookie('v_country_id')        || this.filters.country);
            // this.filters.media   = (this._getCookie('v_media_type_id')     || this.filters.media);
            // this.filters.page    = (this._getCookie('v_page')              || this.filters.page);
            // this.filters.key     = (this._getCookie('v_key')               || this.filters.key);

            this.getAllComboBox();
            this._bindFilters();
            this.getVehicles();
            this._getIds();
        },

        updated: function () {
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

                    if(ids.length > 1) {
                        $('.btn-multiple').prop("disabled",false);
                    } else {
                        $('.btn-multiple').prop("disabled",true);
                    }
                });


            $('.btn-multiple').prop("disabled",true);
            this._getIds();
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
                    <div class="form-group col-md-3">
                        <label>Status</label>
                        <select class="form-control select2" name="cb_status" id="cb_status">
                            <option value="0">Todos</option>
                            <option v-for="status in status" :key="status.id" :value="status.id" :selected="filters.status==status.id ? true : false">{{ status.description }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>País</label>
                        <select class="form-control select2" name="cb_country" id="cb_country">
                            <option value="0">Todos</option>
                            <option value="outside" :selected="filters.country=='outside' ? true : false">Internacionais</option>
                            <option v-for="country in countries" :key="country.id" :value="country.id" :selected="filters.country==country.id ? true : false">{{ country.description }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Mídia</label>
                        <select class="form-control select2" name="cb_media" id="cb_media">
                            <option value="0">Todos</option>
                            <option v-for="media in mediaTypes" :key="media.id" :value="media.id" :selected="filters.media==media.id ? true : false">{{ media.description }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exampleInputEmail1">Palavra chave</label>
                        <input type="text" class="form-control" id="key" name="key" placeholder="Palavra chave" :value="filters.key">
                    </div>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button class="btn btn-default" v-on:click="_bindClearFilters">Limpar</button>
                    <button class="btn btn-info pull-right" id="btn-submit">Filtrar</button>
                </div>
                <div class="pull-left">
                    <button class="btn btn-success" v-on:click="_bindRedirect('veiculos/novo')">Novo Veículo</button>
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

    <div v-if="ready==true && vehicles.length > 0" >

        <div class="box">
            <div class="box-header">
                <div class="pull-left">
                    <button class="btn btn-danger btn-multiple" v-on:click="_bindEditMultiple()" disabled>Multipla edição</button>
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
                            <th width='50'></th>
                            <th>Código</th>
                            <th>Veículo</th>
                            <th>URL</th>
                            <th>Origem</th>
                            <th>Mídia</th>
                            <th>Status</th>
                            <th width='100' >Ações</th>
                        </tr>
                        <tr v-for="vehicle in vehicles" :key="vehicle.id" :data-id="vehicle.id">
                            <td><input type="checkbox" @click="testEvent"></td>
                            <td>{{ vehicle.id }}</td>
                            <td>{{ vehicle.description }}<br>{{ vehicle.unify_id > 0 ? vehicle.unify.description + ' (unificado)' : '' }}</td>
                            <td><a :href="vehicle.url" target="_blank">{{ vehicle.url.match(/clipping.cservice.com.br/) ? 'LINK' : vehicle.url }}</a></td>
                            <td>{{ vehicle.from }}</td>
                            <td>{{ vehicle.media_type ? vehicle.media_type.description : '' }}</td>
                            <td>{{ vehicle.status.description }}</td>
                            <td>
                                <a href="javascript:;" class="edit" v-on:click="_bindRedirect('veiculos/' + vehicle.id)"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pull-left">
                    <button class="btn btn-danger btn-multiple" v-on:click="_bindEditMultiple()" disabled>Multipla edição</button>
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
