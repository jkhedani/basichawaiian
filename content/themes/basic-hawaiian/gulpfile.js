var gulp        = require('gulp');
var plumber     = require('gulp-plumber');
var less        = require('gulp-less');
var sourcemaps  = require('gulp-sourcemaps');
var minifycss   = require('gulp-minify-css');

/**
 * Less
 */
var lesssrc     = './less/**';
var lessdest    = './';
gulp.task('less', function() {
  gulp.src( lesssrc )
  .pipe(plumber())
  //.pipe(sourcemaps.init({loadMaps: true}))
  //.pipe(concat('all.less'))
  .pipe(less())
  .pipe(minifycss())
  // .pipe(rename({ suffix: '.min' }))
  // .pipe(sourcemaps.write('maps'))
  .pipe(gulp.dest( lessdest ));
});

/**
 * Watch
 */
gulp.task('watch', function() {
  gulp.watch( lesssrc,  ['less']);
});

/**
 * Default Gulp Tasks
 */
gulp.task('default', ['watch','less']);
