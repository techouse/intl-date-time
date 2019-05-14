const mix                    = require('laravel-mix'),
      postCssDiscardComments = require('postcss-discard-comments')

mix.setPublicPath('dist')
   .js('resources/js/field.js', 'js')
   .sass('resources/sass/field.scss', 'css')
   .options({
       publicPath: 'dist',

       cleanCss: {
           level: {
               1: {
                   specialComments: 'none'
               }
           }
       },

       postCss: [
           postCssDiscardComments({removeAll: true})
       ],
   })
   .version()
    //.sourceMaps()
    //.disableNotifications()
