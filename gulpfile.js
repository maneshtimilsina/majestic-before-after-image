// Env.
require('dotenv').config();

// Config.
const rootPath = './';

// Gulp.
const gulp = require('gulp');

// Babel.
const babel = require('gulp-babel');

// Plumber.
const plumber = require('gulp-plumber');

// Autoprefixer.
const autoprefixer = require('gulp-autoprefixer');

// SASS.
const sass = require('gulp-sass')(require('sass'));

// Sourcemaps.
const sourcemaps = require('gulp-sourcemaps');

// Browser sync.
const browserSync = require('browser-sync').create();

// Environments.
var environments = require('gulp-environments');
var development = environments.development;

// Error Handling.
var onError = function( err ) {
		console.log( 'An error occurred:', err.message );
		this.emit( 'end' );
};

// Style.
gulp.task('style', function () {
	return gulp.src(rootPath + 'src/sass/*.scss')
		.pipe( development( sourcemaps.init() ) )
		.pipe(sass().on('error', sass.logError))
		.pipe(development(sourcemaps.write({includeContent: false})))
		.pipe(development(sourcemaps.init({loadMaps: true})))
		.pipe(plumber())
		.pipe(sass())
		.pipe(autoprefixer())
		.pipe(development(sourcemaps.write('.')))
		.pipe(gulp.dest(rootPath + 'assets/css'))
});

// Script.
gulp.task('script', function() {
		return gulp.src( [rootPath + 'src/scripts/*.js'] )
			.pipe(development(sourcemaps.init()))
			.pipe(babel({
				presets: ['@babel/env']
			}))
			.pipe(development(sourcemaps.write('.')))
			.pipe(gulp.dest(rootPath + 'assets/js'))
});

// Watch.
gulp.task( 'watch', function() {
		browserSync.init({
				proxy: process.env.DEV_SERVER_URL,
				open: true
		});

		// Watch SCSS files.
		gulp.watch(rootPath + 'src/sass/**/*.scss', gulp.series('style')).on('change',browserSync.reload);

		// Watch JS files.
		gulp.watch(rootPath + 'src/scripts/**/*.js', gulp.series('script')).on('change',browserSync.reload);

		// Watch PHP files.
		gulp.watch(rootPath + '**/**/*.php').on('change',browserSync.reload);
});

// Tasks.
gulp.task( 'default', gulp.series('watch'));
gulp.task( 'build', gulp.series('style', 'script'));
