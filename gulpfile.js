var elixir = require('laravel-elixir');

//  bowerDir = "vendor/bower_components/";

require('laravel-elixir-livereload');

elixir(function(mix) {
    mix.browserSync();
    //  mix.livereload();
});


