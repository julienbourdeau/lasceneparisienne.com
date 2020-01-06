const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./resources/tailwind.config.js') ],
    })
    .browserSync({
        proxy: 'lascenenantaise.com.test'
    })
;

if (mix.inProduction()) {
    mix.purgeCss()
       .version();
}
