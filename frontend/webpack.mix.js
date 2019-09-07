let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css').options({
        processCssUrls: false
    });

if (mix.inProduction()) {
    mix.version();
}

if (!mix.inProduction()) {
    mix.sourceMaps();
}