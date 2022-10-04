let mix = require('laravel-mix')

mix.options({
    processCssUrls: false
})

/* Arquivos Sass */
mix.sass('resources/assets/sass/app.scss', 'public/assets/css/app.min.css')

/* Arquivos Less */
mix.less('resources/assets/less/admin.less', 'public/assets/css/admin.min.css')

/* Estilos Site */
mix.less('resources/assets/less-site/pages/home.less', 'assets/css/pages/home.min.css')
    .less('resources/assets/less-site/pages/news.less', 'assets/css/pages/news.min.css')
    .less('resources/assets/less-site/pages/vehicles.less', 'assets/css/pages/vehicles.min.css')
    .less('resources/assets/less-site/pages/search.less', 'assets/css/pages/search.min.css')

/* Estilos Individuais */
mix.less('resources/assets/less/login.less', 'public/assets/css/login.min.css')
    .less('resources/assets/less/users.less', 'public/assets/css/users.min.css')


/* Arquivos javascript */
mix.js('resources/assets/js/app.js', 'public/assets/js/app.min.js')
    .js('resources/assets/js/vue.js', 'public/assets/js/admin.min.js')
    .js([
        'resources/assets/js/adminlte.js',
        'resources/assets/vendor/lazy/jquery.lazy.min.js',
        'resources/assets/js/general.js'
    ], 'public/assets/js/general.min.js')

/* Scripts Site */
mix.js('resources/assets/js-site/main.js', 'assets/js/site.min.js')
    .js('resources/assets/js-site/home.js', 'assets/js/pages/home.min.js')
    .js('resources/assets/js-site/search.js', 'assets/js/pages/search.min.js')

/* Scripts Individuais */
mix.js('resources/assets/js/users.js', 'public/assets/js/users.min.js')
    .js('resources/assets/js/pages/post-edit.js', 'public/assets/js/admin/post-edit.min.js')
    .js('resources/assets/js/pages/import-test.js', 'public/assets/js/admin/import-test.min.js')
    .js('resources/assets/js/pages/post-order.js', 'public/assets/js/admin/post-order.min.js')
    .js('resources/assets/js/pages/news-edit-multiple.js', 'public/assets/js/admin/news-edit-multiple.min.js')
    .js('resources/assets/js/pages/vehicle-edit.js', 'public/assets/js/admin/vehicle-edit.min.js')
    .js('resources/assets/js/pages/session-edit.js', 'public/assets/js/admin/session-edit.min.js')
    .js('resources/assets/js/pages/vehicle-edit-multiple.js', 'public/assets/js/admin/vehicle-edit-multiple.min.js')
    .js('resources/assets/js/pages/news-list.js', 'public/assets/js/admin/news-list.min.js')
    .js('resources/assets/js/pages/dashboard.js', 'public/assets/js/admin/dashboard.min.js')
    .js('resources/assets/js/pages/news-report.js', 'public/assets/js/admin/news-report.min.js')
    .js('resources/assets/js/pages/url-edit.js', 'public/assets/js/admin/url-edit.min.js')

const PORT = 3000;
const PORTUI = PORT + 100;
mix.browserSync({
    proxy: 'localhost:2000',
    port: PORT,
    ui: {
        port: PORTUI
    },
    files: ["public/assets/css/*.css", "public/assets/js/*.js", "resources/views/**/*"]
})