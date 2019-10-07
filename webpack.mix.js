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

mix.js('resources/assets/js/admin/app.js', 'public/js/admin')
  .js('resources/assets/js/admin/promo-container.js', 'public/js/admin')
  .sass('resources/assets/sass/admin/app.scss', 'public/css/admin')
  .sass('resources/assets/sass/admin/pages/products.scss', 'public/css/admin/pages');

mix.js('resources/assets/js/site/app.js', 'public/js/site')
  .js('resources/assets/js/site/home.js', 'public/js/site')
  .js('resources/assets/js/site/shop.js', 'public/js/site')
  .js('resources/assets/js/site/shop2.js', 'public/js/site')
  .js('resources/assets/js/site/product.js', 'public/js/site')
  .js('resources/assets/js/site/cart.js', 'public/js/site')
  .sass('resources/assets/sass/site/app.scss', 'public/css/site')
  .sass('resources/assets/sass/site/pages/home.scss', 'public/css/site/pages')
  .sass('resources/assets/sass/site/pages/cart.scss', 'public/css/site/pages')
  .sass('resources/assets/sass/site/pages/wishlist.scss', 'public/css/site/pages')
  .sass('resources/assets/sass/site/pages/faq.scss', 'public/css/site/pages')
  .sass('resources/assets/sass/site/pages/categories.scss', 'public/css/site/pages')
  .sass('resources/assets/sass/site/pages/checkout.scss', 'public/css/site/pages')
  .sass('resources/assets/sass/site/pages/shop.scss', 'public/css/site/pages')
  .sass('resources/assets/sass/site/pages/product.scss', 'public/css/site/pages')
  .sass('resources/assets/sass/site/pages/auth.scss', 'public/css/site/pages')
  .sass('resources/assets/sass/site/pages/nosotros.scss', 'public/css/site/pages')
  .sass('resources/assets/sass/site/pages/404.scss', 'public/css/site/pages')
  .sass('resources/assets/sass/site/pages/contactanos.scss', 'public/css/site/pages');


mix.version()