require( 'dotenv' ).config();

const rootPath = './';
const gulp = require( 'gulp' );
const babel = require( 'gulp-babel' );
const sourcemaps = require( 'gulp-sourcemaps' );
const browserSync = require( 'browser-sync' ).create();
const postcss = require( 'gulp-postcss' );
const postcssPresetEnv = require( 'postcss-preset-env' );
const postcssNested = require( 'postcss-nested' );
const environments = require( 'gulp-environments' );
const development = environments.development;

gulp.task( 'style', function () {
	return gulp
		.src( rootPath + 'resources/styles/*.css' )
		.pipe( development( sourcemaps.init() ) )
		.pipe( development( sourcemaps.write( { includeContent: false } ) ) )
		.pipe( development( sourcemaps.init( { loadMaps: true } ) ) )
		.pipe( postcss( [ postcssPresetEnv(), postcssNested() ] ) )
		.pipe( development( sourcemaps.write( '.' ) ) )
		.pipe( gulp.dest( rootPath + 'assets/css' ) );
} );

gulp.task( 'script', function () {
	return gulp
		.src( [ rootPath + 'resources/scripts/*.js' ] )
		.pipe( development( sourcemaps.init() ) )
		.pipe(
			babel( {
				presets: [ '@babel/env' ],
			} )
		)
		.pipe( development( sourcemaps.write( '.' ) ) )
		.pipe( gulp.dest( rootPath + 'assets/js' ) );
} );

gulp.task( 'watch', function () {
	browserSync.init( {
		proxy: process.env.DEV_SERVER_URL,
		open: 'yes' === process.env.BROWSERSYNC_OPEN ? true : false,
	} );

	gulp.watch(
		rootPath + 'resources/sass/**/*.scss',
		gulp.series( 'style' )
	).on( 'change', browserSync.reload );
	gulp.watch(
		rootPath + 'resources/scripts/**/*.js',
		gulp.series( 'script' )
	).on( 'change', browserSync.reload );
	gulp.watch( rootPath + '**/**/*.php' ).on( 'change', browserSync.reload );
} );

gulp.task( 'default', gulp.series( 'watch' ) );
gulp.task( 'build', gulp.series( 'style', 'script' ) );
