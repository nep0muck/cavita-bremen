/*
Gulpfile.js file for the tutorial:
Using Gulp, SASS and Browser-Sync for your front end web development - DESIGNfromWITHIN
http://designfromwithin.com/blog/gulp-sass-browser-sync-front-end-dev
Steps:
1. Install gulp globally:
npm install --global gulp
2. Type the following after navigating in your project folder:
npm install gulp gulp-util gulp-sass gulp-uglify gulp-rename gulp-minify-css gulp-notify gulp-concat gulp-plumber browser-sync --save-dev
3. Move this file in your project folder
4. Setup your vhosts or just use static server (see 'Prepare Browser-sync for localhost' below)
5. Type 'Gulp' and ster developing
*/

/* Needed gulp config */
var gulp = require('gulp');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var neat = require('node-neat');
var notify = require('gulp-notify');
var minifycss = require('gulp-cssnano');
var concat = require('gulp-concat');
var plumber = require('gulp-plumber');
var browserSync = require('browser-sync');
var reload = browserSync.reload;

var config = {
    sassPath: './css',
    nodeDir: './node_modules',
    wpDir: 'C:/xampp/htdocs/wordpress/wp-content/themes/cavita-bremen',
}

/* Scripts task */
gulp.task('scripts', function() {
  return gulp.src([
    /* Add your JS files here, they will be combined in this order */
    'js/jquery.js',
    'js/app.js'
    ])
    .pipe(concat('main.js'))
    .pipe(gulp.dest('js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest('js'));
});

/* Sass task */
gulp.task('sass', function () {
    return gulp.src(config.sassPath + '/style.scss')
    .pipe(plumber())
    .pipe(sass({
        style: 'compressed',
        includePaths: [
            config.sassPath,
        ].concat(neat)
    }))
    .pipe(gulp.dest(config.wpDir))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest(config.wpDir))
    .pipe(reload({stream:true}));
});


/* Prepare Browser-sync for localhost */
gulp.task('browser-sync', function() {
    browserSync.init(['css/*.css', 'js/*.js'], {
        /*
        I like to use a vhost, WAMP guide: https://www.kristengrote.com/blog/articles/how-to-set-up-virtual-hosts-using-wamp, XAMP guide: http://sawmac.com/xampp/virtualhosts/
        */
        proxy: 'http://localhost:8080/wordpress/'
        /* For a static server you would use this: */
        /*
        server: {
            baseDir: './'
        }
        */
    });
});


/* Reload task */
gulp.task('bs-reload', function () {
    browserSync.reload();
});


/* Watch scss, js and html files, doing different things with each. */
gulp.task('default', ['sass', 'browser-sync'], function () {
    /* Watch scss, run the sass task on change. */
    gulp.watch(['css/*.scss', 'css/**/*.scss', 'css/*.sass', 'css/**/*.sass'], ['sass'])
    /* Watch app.js file, run the scripts task on change. */
    gulp.watch(['js/app.js'], ['scripts'])
    /* Watch .css files, run the bs-reload task on change. */
    gulp.watch(['*.css'], ['bs-reload']);
    /* Watch .html files, run the bs-reload task on change. */
    gulp.watch(['*.html'], ['bs-reload']);
});
