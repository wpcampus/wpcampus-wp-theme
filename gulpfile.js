// Require all the things (that we need).
var gulp = require('gulp');
var phpcs = require('gulp-phpcs');
var rename = require('gulp-rename');
var sort = require('gulp-sort');
var uglify = require('gulp-uglify');
var watch = require('gulp-watch');
var wp_pot = require('gulp-wp-pot');

// Define the source paths for each file type.
var src = {
	js: ['assets/js/wpcampus.js', 'assets/js/wpcampus-data.js', 'assets/js/wpcampus-sessions.js'],
	php: ['**/*.php','!vendor/**','!node_modules/**']
};

// Minify the JS.
gulp.task('js', function() {
    gulp.src(src.js)
        .pipe(uglify({
            mangle: false
        }))
        .pipe(rename({
			suffix: '.min'
		}))
        .pipe(gulp.dest('assets/js'))
});

// Sniff our code.
gulp.task('php',function () {
	return gulp.src(src.php)
		.pipe(phpcs({
			bin: './vendor/bin/phpcs',
			standard: 'WordPress-Core'
		}))
		// Log all problems that was found
		.pipe(phpcs.reporter('log'));
});

// Create the .pot translation file.
gulp.task('translate', function () {
    gulp.src('**/*.php')
        .pipe(sort())
        .pipe(wp_pot( {
            domain: 'wpcampus',
            package: 'wpcampus-wp-theme',
            bugReport: 'https://github.com/wpcampus/wpcampus-wp-theme/issues',
            lastTranslator: 'WPCampus <code@wpcampus.org>',
            team: 'WPCampus <code@wpcampus.org>',
            headers: false
        } ))
        .pipe(gulp.dest('languages/wpcampus-wp-theme.pot'));
});

// Compile all the things.
gulp.task('compile',['js']);

// Test all the things.
gulp.task('test',['php']);

// I've got my eyes on you(r file changes).
gulp.task('watch', function() {
	gulp.watch(src.js, ['js']);
	gulp.watch(src.php, ['translate','php']);
});

// Let's get this party started.
gulp.task('default', ['compile','translate','test']);