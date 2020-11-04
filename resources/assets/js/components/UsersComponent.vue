<script>
    import {users, toastrOptions} from "./constants/objects";

    export default {
        props: ['id'],
        data: function () {
            return {
                baseUrl,
                ready: false,
                list:  [],
                modal: {
                    title: '',
                    user: users
                },
                errors: []
            }
        },

        methods: {
            getUsers: function () {
                let url = baseUrl + "api/admin/ajax/get-users/" + this.id;

                axios.get(url).then(response => {
                    this.ready = true;
                    this.list  = response.data;
                }).catch(error => {
                    console.log('Error: ' + error.response.status + ' / ' + error.response.data);
                });
            },

            saveUser: function () {
                let data = new FormData();

                data.append('type', this.modal.user.type);
                data.append('image', this.modal.user.image);
                data.append('name', this.modal.user.name);
                data.append('email', this.modal.user.email);
                data.append('actived', this.modal.user.actived);

                let url     = baseUrl + "api/admin/ajax/create-user";
                let message = "Usuário incluído com sucesso!";
                if(this.modal.user.id>0) {
                    data.append('id', this.modal.user.id);
                    message = "Usuário atualizado com sucesso!";
                }

                axios.post(url, data).then(response => {
                    this.modal.user = users;
                    this.errors     = [];

                    this.getUsers();
                    $('#create-user').modal('hide');
                    $('#create-user').find('.errors').html("");

                    toastr.options  = toastrOptions;
                    toastr.success(message);
                }).catch(error => {
                    this.errors = error.response.data;
                });
            },

            deleteUser: function (id) {
                let url = baseUrl + "api/admin/ajax/del-user/"+id;

                axios.delete(url).then(response => {
                    this.list = this.list.filter(x => x.id !== id);

                    toastr.options = toastrOptions;
                    toastr.success("Usuário excluído com sucesso!");
                });
            },

            _bindInfos: function (event) {
                let boxTP = $(event.target).parent().parent().parent();
                if($(event.target)[0].nodeName=='I') boxTP = boxTP.parent();

                boxTP.parent().find('.delUser, .userInfos').css('top', '100%');
                boxTP.find('.userInfos').css('top', '0');
            },

            _bindClose: function (event) {
                let boxTP = $(event.target).parent().parent().parent().parent().parent();
                if($(event.target).hasClass('cancel')) boxTP = boxTP.parent();
                boxTP.find('.delUser, .userInfos').css('top', '100%');
            },

            _bindNew: function () {
                this.modal.title = 'Adicionando novo usuário';
                $('#create-user').modal('show');
            },

            _bindEdit: function (user) {
                let newUser = {
                    id: user.id,
                    type: user.type,
                    image: user.image,
                    name: user.name,
                    email: user.email,
                    actived: user.actived
                };

                this.modal.title  = 'Editando usuário';
                this.modal.user = newUser;
                $('#create-user').modal('show');
            },

            _bindDelete: function (event) {
                let boxTP = $(event.target).parent().parent().parent();
                if($(event.target)[0].nodeName=='I') boxTP = boxTP.parent();

                boxTP.parent().find('.delUser, .userInfos').css('top', '100%');
                boxTP.find('.delUser').css('top', '0');
            },

            _bindImageBox: function () {
                let local = this;

                $('.create-user > .modal-dialog > .modal-content > .modal-body > .row > div > .imageBox').on('click', 'img', function() {
                    $(this).parent().find('input[type="file"]').trigger( "click" );
                }).on('change', 'input[type="file"]', function() {
                    let imageBox  = $(this).parent(),
                        idUser    = imageBox.parent().parent().parent().parent().parent().find('input[name="id"]').val(),
                        inputFile = $(this),
                        error     = false;

                    let imageOrig = (imageBox.find('img').attr('src')!='' ? imageBox.find('img').attr('src') : '');
                    imageBox.parent().find('.errors').html("");
                    imageBox.find('img').attr('src', (idUser > 0 && imageOrig!='' ? imageOrig : baseUrl + 'assets/img/user.jpg'));

                    if (this.files && this.files[0]) {
                        let file      = this.files[0],
                            reader    = new FileReader();

                        reader.onload = function(e) {
                            let image    = new Image();
                            image.src    = reader.result;

                            image.onload = function() {
                                let imgWidth  = image.width,
                                    imgHeight = image.height,
                                    imgSize   = (file.size / 1024).toFixed(2);

                                if(imgWidth==imgHeight && imgWidth <= 500) {
                                    console.log("Largura:", imgWidth);
                                    console.log("Altura:", imgHeight);
                                    console.log("Tamanho:", imgSize + ' KB');
                                    imageBox.find('img').attr('src', e.target.result);
                                } else {
                                    imageBox.parent().find('.errors').html("Imagem com proporções erradas");
                                    inputFile.val('');
                                    local.modal.user.image = imageOrig;
                                }
                            };
                        }

                        reader.readAsDataURL(this.files[0]);
                    }
                });
            },

            toogleActive: function (user) {
                toastr.options = toastrOptions;

                let url    = baseUrl + "api/admin/ajax/published-user",
                    status = !user.actived;

                axios.post(url, {id: user.id, status: status}).then(resp => {
                    let type     = (resp.data.status ? 'ativado' : 'inativado');
                    user.actived = resp.data.status;

                    toastr.success(`Usuário ${type} com sucesso!`);
                }).catch(error => {
                    toastr.error("Erro ao publicar/despublicar o Usuário!");
                });
            }
        },

        mounted: function () {
            this.getUsers();
            this._bindImageBox();

            let local = this;
            $('input').on('ifChanged', function(event) {
                $('#'+this.id+':checkbox').attr('checked', function(idx, oldAttr) {
                    oldAttr = (typeof oldAttr === 'undefined' ? false : true);

                    switch (this.id) {
                        case 'userActived':
                            local.modal.user.actived = (!oldAttr ? 1 : 0);
                            break;
                        case 'userVerified':
                            local.modal.user.is_verified = (!oldAttr ? 1 : 0);
                            break;
                    }

                    return !oldAttr;
                });
            });

            /* Masks */
            $('input#userBirth').inputmask({
                "alias": "datetime",
                "inputFormat": "dd-mm-yyyy",
                "min": "01-01-1970",
                "max": "31-12-2005"
            }).on('change keyup', function () {
                console.log('birth', $(this).val());
                local.modal.user.birth = $(this).val();
            });

            $('input#userPhone').inputmask({"mask": "(99) 9999.9999[9]"}).on('change keyup', function () {
                console.log('phone', $(this).val());
                local.modal.user.phone = $(this).val();
            });

            /* Close Modal */
            $('#create-user').on('hidden.bs.modal', () => {
                this.modal.title  = '';
                this.modal.user = users;
            });

            /* New user button */
            $("#buttons > button.btnNew").on("click", () => {
                this._bindNew();
            });
        },

        updated: () => {
            $('input').iCheck('update');
        }
    }
</script>

<template>
    <div class="col-xs-12 no-padding">
        <div v-if="ready==true" v-for="user in list" id="boxUsers" :key="user.id" :data-search="user.name" :data-ref="`user${user.id}`" class="users col-xs-12 col-sm-6 col-lg-4">
            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-aqua-active">
                    <div class="widget-user-image" v-lazy-container="{ selector: 'img', error: baseUrl + 'assets/img/user.jpg', loading: baseUrl + 'assets/img/user.jpg' }">
                        <img class="img-circle lazy" :data-src="(typeof user.image==='string' ? user.image : baseUrl + 'assets/img/user.jpg')" :alt="user.name" />
                    </div>

                    <h3 class="widget-user-username">{{ user.name }}</h3>
                    <h5 class="widget-user-desc">{{ (user.type==='app' ? 'Usuário' : 'Administrador') }}</h5>
                </div>

                <div class="box-buttons">
                    <a href="javascript:;" :class="`status col-xs-2${user.actived ? ' active' : ''}`" v-on:click="toogleActive(user)">
                        <i v-if="user.actived" class="fa fa-circle"></i>
                        <i v-else class="fa fa-circle-o"></i>
                    </a>

                    <a href="javascript:;" class="edit col-xs-5" v-on:click="_bindEdit(user)">
                        <i class="fa fa-pencil"></i>
                    </a>

                    <a href="javascript:;" class="del col-xs-5" v-on:click="_bindDelete">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </div>

            <div class="delUser">
                <div class="header">
                    <h3 class="title">Excluir usuário?</h3>
                    <div class="buttons">
                        <a href="javascript:;" class="closeBox" v-on:click="_bindClose"><i class="fa fa-times"></i></a>
                    </div>
                </div>

                <div class="body">
                    <div class="message">
                        Deseja realmente excluir este usuário? Este processo é irreversível.
                    </div>

                    <div class="buttons">
                        <a href="javascript:;" class="del col-xs-6" v-on:click="deleteUser(user.id)">
                            Excluir
                        </a>

                        <a href="javascript:;" class="cancel col-xs-6" v-on:click="_bindClose">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="ready==false" id="noBoxs" class="text-red text-center">
            <img class="loading" :src="baseUrl + 'assets/img/loading.svg'" />
        </div>

        <div id="create-user" aria-labelledby="Label" role="dialog" tabindex="-1" class="create-user modal fade">
            <form class="modal-dialog" enctype="multipart/form-data" v-on:submit.prevent="saveUser" method="POST">
                <input v-if="modal.user.id>0" type="hidden" name="id" :value="modal.user.id">
                <input v-else type="hidden" name="id" value="0">

                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">{{ modal.title }}</h4>
                    </div>

                    <div class="modal-body clearfix">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <div class="imageBox">
                                    <input type="file" name="foto do usuário" id="userPhoto" @change="modal.user.image=$event.target.files[0]" accept="image/*" />
                                    <img id="preview" :src="modal.user.image!='' && (typeof modal.user.image!='string' || (typeof modal.user.image=='string' && modal.user.image.indexOf('user.jpg') < 0)) ? modal.user.image : baseUrl + 'assets/img/user.jpg'" alt="Foto do Usuário" />
                                </div>

                                <div class="errors text-red"></div>
                            </div>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="userName">Nome</label>
                                    <input v-model="modal.user.name" type="text" name="nome do usuário" id="userName" class="form-control" placeholder="Entre com o nome" required>
                                </div>
                            </div>

                            <div class="col-xs-7 col-sm-3 no-padding-left">
                                <div class="form-group">
                                    <label for="userType">Tipo</label>
                                    <select id="userType" class="form-control" name="tipo de usuário" v-model="modal.user.type" required>
                                        <option :value="''" :selected="(modal.user.type=='' ? true : false)">-- Selecione --</option>
                                        <optgroup label="Tipos">
                                            <option value="admin" :selected="(modal.user.type=='admin' ? true : false)">Administrador</option>
                                            <option value="app" :selected="(modal.user.type=='app' ? true : false)">Usuário</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-5 col-sm-3 no-padding-left">
                                <div class="form-group">
                                    <label for="userActived">Status</label><br>

                                    <select id="userActived" class="form-control" name="status do usuário" v-model="modal.user.actived" required>
                                        <optgroup label="Status">
                                            <option value="1" :selected="(modal.user.actived===1 ? true : false)">Ativo</option>
                                            <option value="0" :selected="(modal.user.actived===0 ? true : false)">Inativo</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="userEmail">Email</label>
                                    <input v-model="modal.user.email" type="text" name="email do usuário" id="userEmail" class="form-control" placeholder="user@provedor.com.br" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div v-for="error in errors">
                                @{{ error }}
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div id="modalButtons">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
                            <button type="button" aria-label="Close" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-close"></i> Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped=""></style>
