/**
 *
 * gulpfile v 1.1.0
 *
 */

const gulp = require('gulp');
const scss = require('gulp-scss');
const cssmin = require('gulp-cssmin');
const watch = require('gulp-watch');
const rename = require('gulp-rename');
const babelify = require('babelify');
const browserify = require('browserify');
const v_buffer = require('vinyl-buffer');
const v_source = require('vinyl-source-stream');
const uglify = require('gulp-uglify');
const sourcemaps = require('gulp-sourcemaps');
const environments = require('gulp-environments');
const polyfiller = require('gulp-polyfiller');
const concat = require('gulp-concat');

// set evironment variables
var development = environments.development;
var production = environments.production;

// gulp javascript task - bundle and minify es6 to es5 and create a sourcemap
//gulp.task('js', function(){
//    var bundler = browserify({
//        entries: 'app/source.js',
//        debug: true
//    });
//    bundler.transform(babelify, {
//        presets: "es2015"
//    });
//
//    bundler.bundle()
//        .on("error", function(err){ console.error(err); })
//        .pipe(v_source('source.js'))
//        .pipe(v_buffer())
//        .pipe(development(sourcemaps.init({ loadMaps: true })))
//        .pipe(rename('build.min.js'))
//        .pipe(production(polyfiller(['Promise', 'Array.from'])))
//        .pipe(production(concat('build.min.js')))
//        .pipe(production(uglify()))
//        .pipe(development(sourcemaps.write('./')))
//        .pipe(gulp.dest('./dist/js/'));
//});

// gulp SCSS task - compile SCSS documents and minify
gulp.task('scss', function(){
	return gulp.src('./app/resources/styles/style.scss')
	.pipe(scss().on('error', function(err){
		console.log(err);
	}))
	.pipe(production(cssmin().on('error', function(err){
		console.log(err);
	})))
	.pipe(gulp.dest('./'));
});

// gulp ie task - compile SCSS documents for IE
//gulp.task('ie', function(){
//    return gulp.src('./app/styles/ie.scss')
//    .pipe(scss().on('error', function(err){
//        console.log(err);
//    }))
//    .pipe(production(cssmin().on('error', function(err){
//        console.log(err);
//    })))
//    .pipe(gulp.dest('./dist/styles/'));
//});

// gulp task assets - copy assets to dist directory

// gulp watch task - run SCSS and js tasks
gulp.task('watch', function () {
    gulp.watch('./app/resources/styles/**/**.scss', ['scss']);
});

gulp.task('default', ['scss', 'watch']);
