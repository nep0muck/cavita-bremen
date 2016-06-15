var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    less = require('gulp-less'),
    plumber = require('gulp-plumber'),
    autoprefixer = require('gulp-autoprefixer'),
    cssnano = require('gulp-cssnano'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    livereload = require('gulp-livereload'),
    del = require('del');


gulp.task('styles', function() {
  return sass('./less2/**/style.scss')
    .pipe(plumber())
    // .pipe(autoprefixer('last 2 version'))
    .pipe(gulp.dest('./css/'))
    .pipe(rename({suffix: '.min'}))
    .pipe(cssnano({
    discardComments: {
        removeAll: true
    }
}))
    .pipe(gulp.dest('./'))
    .pipe(notify({ message: 'Styles task complete' }));
});


gulp.task('default', function() {
    gulp.start('styles');
});

gulp.task('watch', function() {

  // Watch .scss files
  gulp.watch('less2/**/*.scss', ['styles']);

});


gulp.task('watch', function() {

  // Create LiveReload server
  livereload.listen();

  // Watch any files in dist/, reload on change
  gulp.watch(['./**']).on('change', livereload.changed);

});