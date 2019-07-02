const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.copy('node_modules/admin-lte/bootstrap/fonts/*.*', 'public/fonts/');
mix.copy('node_modules/font-awesome/fonts/*.*', 'public/fonts/');

mix.js('resources/js/app.js', 'public/js');

mix.sass('resources/sass/app.scss', 'public/css');

mix.scripts([
    'node_modules/admin-lte/plugins/jQuery/jquery-2.2.3.min.js',
    'node_modules/admin-lte/bootstrap/js/bootstrap.js',
    'node_modules/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js',
    'node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js',
    'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap.min.js',
    'node_modules/admin-lte/plugins/datatables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js',
    'node_modules/admin-lte/dist/js/app.js'
], 'public/js/admin-lte.js');

mix.styles([
    'node_modules/font-awesome/css/font-awesome.css',
    'node_modules/admin-lte/bootstrap/css/bootstrap.css',
    'node_modules/admin-lte/dist/css/AdminLTE.css',
    'node_modules/admin-lte/dist/css/skins/skin-blue.css',
    'node_modules/admin-lte/plugins/datatables/dataTables.bootstrap.css'
], 'public/css/admin-lte.css');

if (mix.inProduction()) {
    mix.version();
}
