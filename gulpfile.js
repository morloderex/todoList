var elixir = require('laravel-elixir');
require('laravel-elixir-vueify');

// Disable notify
process.env.DISABLE_NOTIFIER = true
require('elixir-vuemaker')

elixir.config.js.browserify.transformers.push({ name: 'envify' })

// Generate source map for easier debugging in dev tools
elixir.config.js.browserify.options.debug = true

var assets = [
    'js/bootstrap.js',
    'js/app.js',
    'js/vendor.js',
    'css/app.css',
    'css/vendor.css'
];

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix
        .sass('app.scss', 'public/css/app.css')

        // copy over node modules
        .copy('node_modules/jquery/dist/jquery.min.js', 'resources/assets/js/vendor/jquery.min.js')
        .copy('node_modules/lity/dist/lity.js', 'resources/assets/js/vendor/lity.js')
        .copy('node_modules/lity/dist/lity.css', 'resources/assets/css/vendor/lity.css')

        .copy('node_modules/bootstrap-material-design/dist/js/material.min.js', 'resources/assets/js/vendor/material.min.js')
        .copy('node_modules/bootstrap-material-design/dist/js/ripples.min.js', 'resources/assets/js/vendor/ripples.min.js')

        .copy('node_modules/tether/dist/js/tether.min.js', 'resources/assets/js/vendor/tether.min.js')
        .copy('node_modules/tether/dist/css/tether.min.css', 'resources/assets/css/vendor/tether.min.css')

        .copy('node_modules/waves/dist/waves.min.js', 'resources/assets/js/vendor/waves.min.js')

        // Compile any vanilla JS to app.js
        .scripts(['*.js'], 'public/js/app.js')

        // compile any vanilla JS under a vendor directory to vendor.js
        // Note: be mindful with Vue/vendor as there might be es6
        .scripts(['vendor/*.js', 'Vue/vendor/*.js'], 'public/js/vendor.js')
        .styles(['vendor/*.css'], 'public/css/vendor.css')
        
        .browserify('Vue/bootstrap.js', 'public/js/bootstrap.js')

        .version(assets)
});
