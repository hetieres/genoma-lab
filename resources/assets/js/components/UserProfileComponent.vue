<script>
    import { users } from "./constants/objects";

    var toastrOptions = {
        "closeButton": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
        "showDuration": "300",
        "hideDuration": "300",
        "timeOut": "5000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    export default {
        props: ['user'],
        data: function () {
            return {
                baseUrl,
                data: {},
                modal: {
                    title: '',
                    time: '',
                    user: JSON.parse(JSON.stringify(users))
                },
                errors: []
            }
        },

        methods: {
            _bindProfile: function() {
                $("body > .wrapper > header > nav > .navbar-custom-menu > ul.nav > li.user-menu").on("click", 'a#userProfile', () => {
                    let newUser = {
                        id:      this.data.id,
                        type:    this.data.type,
                        image:   this.data.image,
                        name:    this.data.name,
                        email:   this.data.email,
                        actived: this.data.actived
                    };

                    this.modal.title = 'Perfil do usuário';
                    this.modal.time  = new Date().getTime();
                    this.modal.user  = newUser;
                    $('#profile-user').modal('show');
                });
            },

            _bindImageBox: function () {
                let local = this;

                $('#profile-user > .modal-dialog > .modal-content > .modal-body > .row > div > .imageBox').on('click', 'img', function() {
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

            saveUser: function () {
                this.modal.time = new Date().getTime();
                toastr.options  = toastrOptions;

                let error        = 0,
                    message      = '',

                    userName     = this.modal.user.name.trim(),
                    userEmail    = this.modal.user.email.trim(),
                    userPass     = (this.modal.user.password ? this.modal.user.password.trim() : ''),
                    userPassConf = (this.modal.user.passwordConfirm ? this.modal.user.passwordConfirm.trim() : '');

                if (userName==='') {
                    message += (message!=='' ? '<br>' : '') + 'Informe o seu nome';
                    error = 1;
                }

                if (userEmail==='') {
                    message += (message!=='' ? '<br>' : '') + 'Informe o seu email';
                    error = 1;
                }

                if (userPass!=='' && userPassConf!=='' && userPass!==userPassConf) {
                    message += (message!=='' ? '<br>' : '') + 'A senha e a confirmação devem ser iguais';
                    error = 1;
                } else if (userPass!=='' && userPassConf!=='' && userPass===userPassConf && userPass.length<6) {
                    message += (message!=='' ? '<br>' : '') + 'A senha e deve ter no mínimo 6 digitos';
                    error = 1;
                }

                if (!error) {
                    let data = new FormData();

                    data.append('id', this.modal.user.id);
                    data.append('image', this.modal.user.image);
                    data.append('name', userName);
                    data.append('email', userEmail);
                    data.append('password', userPass);
                    data.append('passwordConfirm', userPassConf);

                    let url     = baseUrl + "api/admin/ajax/edit-user",
                        message = "Usuário atualizado com sucesso!";

                    axios.post(url, data).then(resp => {
                        this.modal.user = JSON.parse(JSON.stringify(users));
                        this.errors     = [];

                        $('#profile-user').modal('hide');
                        $('#profile-user').find('.errors').html("");

                        // Change user data menu
                        let dataUser = resp.data.user,
                            userMenu = $('body > .wrapper > header > nav > .navbar-custom-menu > ul.navbar-nav > li.user-menu');

                        userMenu.find('> a > span').html(dataUser.name);
                        userMenu.find('> ul > li.user-header > p > span').html(dataUser.name);
                        userMenu.find('> ul > li.user-header > img').attr('src', baseUrl + dataUser.image + '?t=' + this.modal.time);

                        this.data = {...this.data, ...dataUser};

                        toastr.success(message);
                    }).catch(error => {
                        this.errors = error.response.data;
                        toastr.error("Erro ao salvar o usuário!");
                    });
                } else {
                    toastr.error('<b>Ocorreu um erro!</b><br>' + message);
                }
            }
        },

        mounted: function () {
            this.data = JSON.parse(this.user);

            // Call binds buttons
            this._bindProfile();
            this._bindImageBox();

            /* Close Modal */
            $('#create-user').on('hidden.bs.modal', () => {
                this.modal.title = '';
                this.modal.user  = JSON.parse(JSON.stringify(users));
            });
        }
    }
</script>

<template>
    <div id="profile-user" aria-labelledby="Label" role="dialog" tabindex="-1" class="profile-user modal fade">
        <form class="modal-dialog" enctype="multipart/form-data" v-on:submit.prevent="saveUser" method="POST">
            <input type="hidden" name="id" :value="modal.user.id">

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
                                <img id="preview" :src="modal.user.image!='' && (typeof modal.user.image!='string' || (typeof modal.user.image=='string' && modal.user.image.indexOf('user.jpg') < 0)) ? baseUrl + modal.user.image + '?t=' + modal.time : baseUrl + 'assets/img/user.jpg'" alt="Foto do Usuário" />
                            </div>

                            <div class="errors text-red"></div>
                        </div>
                    </div>

                    <hr />

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="userName">Nome</label>
                                <input v-model="modal.user.name" type="text" name="nome do usuário" id="userName" class="form-control" placeholder="Entre com o nome" required>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="userEmail">Email</label>
                                <input v-model="modal.user.email" type="text" name="email do usuário" id="userEmail" class="form-control" placeholder="user@provedor.com.br" required>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="userPassword">Senha</label>
                                <input v-model="modal.user.password" type="password" name="email do usuário" id="userPassword" class="form-control">
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="userPasswordConfirm">Confirmação</label>
                                <input v-model="modal.user.passwordConfirm" type="password" name="email do usuário" id="userPasswordConfirm" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div v-for="error in errors" :key="error">
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
</template>

<style scoped=""></style>
