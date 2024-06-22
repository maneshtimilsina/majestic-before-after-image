// Env.
require( 'dotenv' ).config();

// Config.
const rootPath = './';

// Gulp.
const gulp = require( 'gulp' );

// Babel.
const babel = require( 'gulp-babel' );

// Plumber.
const plumber = require( 'gulp-plumber' );

// SASS.
const sass = require( 'gulp-sass' )( require( 'sass' ) );

// Sourcemaps.
const sourcemaps = require( 'gulp-sourcemaps' );

// Browser sync.
const browserSync = require( 'browser-sync' ).create();

// Environments.
const environments = require( 'gulp-environments' );
const development = environments.development;

// Style.
gulp.task( 'style', function() {
	return gulp.src( rootPath + 'resources/sass/*.scss' )
		.pipe( development( sourcemaps.init() ) )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( development( sourcemaps.write( { includeContent: false } ) ) )
		.pipe( development( sourcemaps.init( { loadMaps: true } ) ) )
		.pipe( plumber() )
		.pipe( sass() )
		.pipe( development( sourcemaps.write( '.' ) ) )
		.pipe( gulp.dest( rootPath + 'assets/css' ) );
} );

// Script.
gulp.task( 'script', function() {
	return gulp.src( [ rootPath + 'resources/scripts/*.js' ] )
		.pipe( development( sourcemaps.init() ) )
		.pipe( babel( {
			presets: [ '@babel/env' ],
		} ) )
		.pipe( development( sourcemaps.write( '.' ) ) )
		.pipe( gulp.dest( rootPath + 'assets/js' ) );
} );

// Watch.
gulp.task( 'watch', function() {
	browserSync.init( {
		proxy: process.env.DEV_SERVER_URL,
		open: 'yes' === process.env.BROWSERSYNC_OPEN ? true : false,

	} );

	// Watch SCSS files.
	gulp.watch( rootPath + 'resources/sass/**/*.scss', gulp.series( 'style' ) ).on( 'change', browserSync.reload );

	// Watch JS files.
	gulp.watch( rootPath + 'resources/scripts/**/*.js', gulp.series( 'script' ) ).on( 'change', browserSync.reload );

	// Watch PHP files.
	gulp.watch( rootPath + '**/**/*.php' ).on( 'change', browserSync.reload );
} );

// Tasks.
gulp.task( 'default', gulp.series( 'watch' ) );
gulp.task( 'build', gulp.series( 'style', 'script' ) );
