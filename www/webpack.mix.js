require('dotenv').config();
const mix = require('laravel-mix');
const path = require('path');
const imageminMozjpeg = require('imagemin-mozjpeg');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const FaviconsWebpackPlugin = require('favicons-webpack-plugin');

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

let publicPath = '';
if (mix.inProduction() && process.env.USE_CDN) {
  publicPath = process.env.OBJECT_STORAGE_URL
    ? process.env.OBJECT_STORAGE_URL
    : 'https://pkmn-friends.objects.frb.io/assets/';
  mix
    .version()
    .setResourceRoot('/assets/');
}

mix
  .autoload({
    jquery: ['$', 'window.jQuery', 'jQuery', 'window.$'],
    moment: ['moment', 'window.moment'],
    'popper.js': ['Popper', 'window.Popper'],
    'pusher-js': ['Pusher', 'window.Pusher'],
    'vanilla-lazyload': ['LazyLoad', 'window.LazyLoad'],
    'owl.carousel': ['owlCarousel', 'window.owlCarousel'],
  })
  .webpackConfig({
    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'resources/js'),
      },
      extensions: ['.js', '.vue'],
    },
    module: {
      rules: [{
        enforce: 'pre',
        test: /\.(js|vue)$/,
        loader: 'eslint-loader',
        exclude: /(node_modules|tests)/,
      }],
    },
    plugins: [
      new StyleLintPlugin({
        configFile: '.stylelintrc',
        context: 'resources/sass',
      }),
      new CopyWebpackPlugin([
        {
          from: 'resources/images',
          to: 'images',
        },
      ]),
      new ImageminPlugin({
        test: /\.(jpe?g|png|gif)$/i, // |svg
        pngquant: {
          quality: '65-80',
        },
        plugins: [
          imageminMozjpeg({
            quality: 65,
            // Set the maximum memory to use in kbytes
            maxMemory: 1000 * 512,
          }),
        ],
      }),
      new FaviconsWebpackPlugin({
        logo: path.resolve(__dirname, 'resources/images/pokeball.png'),
        prefix: 'images/',
        cache: true,
        inject: false,
        mode: 'webapp',
        devMode: 'webapp',
        publicPath,
        favicons: {
          background: '#fff',
          theme_color: '#fff',
          icons: {
            coast: false,
            yandex: false,
            favicons: true,
            android: mix.inProduction(),
            appleIcon: mix.inProduction(),
            appleStartup: mix.inProduction(),
            firefox: mix.inProduction(),
            windows: mix.inProduction(),
          },
        },
      }),
    ],
  })
  .sourceMaps(false, 'eval')
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css');
