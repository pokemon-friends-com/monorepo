const mix = require('laravel-mix');
const path = require('path');
const imageminMozjpeg = require('imagemin-mozjpeg');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');

let webpackPlugins = [
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
];

mix
  .autoload({
    jquery: ['$', 'window.jQuery', 'jQuery', 'window.$', 'jquery', 'window.jquery'],
    moment: ['moment', 'window.moment'],
    'pusher-js': ['Pusher', 'window.Pusher'],
  })
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
        {
          // Exposes jQuery for use outside Webpack build
          test: require.resolve('jquery'),
          use: [{
            loader: 'expose-loader',
            options: 'jQuery',
          }, {
            loader: 'expose-loader',
            options: '$',
          }],
        },
      ],
    },
    plugins: [],
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
  .sass('resources/sass/app.scss', 'public/css');

if (mix.inProduction()) {
  mix
    .version()
    .setResourceRoot('/assets.pokemon-friends.com/');
} else {
  mix.sourceMaps();
}

mix.webpackConfig({
  plugins: webpackPlugins
});
