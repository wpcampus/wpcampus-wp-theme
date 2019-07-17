// Require all the things (that we need).
const gulp = require('gulp');
const notify = require('gulp-notify');
const rename = require('gulp-rename');
const shell = require('gulp-shell');
const sort = require('gulp-sort');
const uglify = require('gulp-uglify');
const watch = require('gulp-watch');
const wp_pot = require('gulp-wp-pot');

// Define the source paths for each file type.
const src = {
	js: ['assets/js/wpcampus.js', 'assets/js/wpcampus-data.js'],
	php: ['**/*.php','!vendor/**','!node_modules/**']
};

const dest = {
	js: 'assets/js',
	translations: 'languages/wpcampus-wp-theme.pot'
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
        .pipe(gulp.dest(dest.js))
		.pipe(notify('WPC Main JS compiled'));
});

// "Sniff" our PHP.
gulp.task('php', function() {
	// TODO: Clean up. Want to run command and show notify for sniff errors.
	return gulp.src('index.php', {read: false})
		.pipe(shell(['composer sniff'], {
			ignoreErrors: true,
			verbose: false
		}))
		.pipe(notify('WPC Main PHP sniffed'), {
			onLast: true,
			emitError: true
		});
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
        .pipe(gulp.dest(dest.translations))
		.pipe(notify('WPC Main translated'));
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