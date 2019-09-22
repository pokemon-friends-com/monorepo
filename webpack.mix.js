const mix = require('laravel-mix');
const path = require('path');
const imageminMozjpeg = require('imagemin-mozjpeg');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');

mix
  .webpackConfig({
    resolve: {
      alias: {
        '@': path.resolve(__dirname, './resources/js'),
      },
      extensions: [
        '*',
        '.js',
        '.jsx',
        '.vue',
        '.ts',
        '.tsx',
      ],
    },
    module: {
      rules: [
        {
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules|tests)/,
        },
        {
          test: /\.tsx?$/,
          loader: 'ts-loader',
          options: {
            appendTsSuffixTo: [
              /\.vue$/,
            ],
          },
          exclude: /node_modules/,
        },
      ],
    },
    plugins: [
      new StyleLintPlugin({
        configFile: '.stylelintrc',
        context: 'resources/sass',
      }),
      new CopyWebpackPlugin([
        {
          from: 'resources/clip/html/clip-2/images',
          to: 'img',
        }, {
          from: 'resources/pages/dist/pages/img',
          to: 'img',
        }, {
          from: 'resources/images',
          to: 'images',
        }]),
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
    ],
  });

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

mix
  .js('resources/js/app.js', 'public/js')
  .js('resources/js/backend.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/backend.scss', 'public/css')
  .copy('resources/gameforest/dist/css', 'public/css')
  .copy('resources/gameforest/dist/js', 'public/js')
  .copy('resources/gameforest/dist/fonts', 'public/fonts')
  .copy('resources/pages/dist/pages/css', 'public/css')
  .copy('resources/pages/dist/pages/js', 'public/js')
  .copy('resources/pages/dist/pages/fonts', 'public/fonts')
  .copy('resources/pages/dist/pages/ico', 'public/ico')
  .copy('resources/pages/plugins', 'public/plugins');

if (mix.config.production) {
  mix.version();
} else {
  mix.sourceMaps();
}
