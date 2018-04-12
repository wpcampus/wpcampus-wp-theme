const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const gulp = require('gulp');
const mergeMediaQueries = require('gulp-merge-media-queries');
const normalize = require('node-normalize-scss').includePaths;
const notify = require('gulp-notify');
const rename = require('gulp-rename');
const sass = require('gulp-sass');
const shell = require('gulp-shell');
const sort = require('gulp-sort');
const uglify = require('gulp-uglify');
const wp_pot = require('gulp-wp-pot');

// Define our SASS includes.
const sassIncludes = [].concat(normalize);

// Define the source paths for each file type.
const src = {
	js: ['assets/js/wpcampus.js', 'assets/js/wpcampus-data.js', 'assets/js/wpcampus-sessions.js'],
	php: ['**/*.php','!vendor/**','!node_modules/**'],
	sass: ['assets/scss/**/*']
};

// Define the destination paths for each file type.
const dest = {
	js: 'assets/js',
	sass: 'assets/css',
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

// Take care of SASS.
gulp.task('sass', function() {
	return gulp.src(src.sass)
		.pipe(sass({
			includePaths: sassIncludes,
			outputStyle: 'expanded'
		}).on('error', sass.logError))
		.pipe(mergeMediaQueries())
		.pipe(autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}))
		.pipe(cleanCSS({
			compatibility: 'ie8'
		}))
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest(dest.sass))
		.pipe(notify('WPC Main SASS compiled'));
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

// Test our files.
gulp.task('test',['php']);

// Compile all the things.
gulp.task('compile',['sass','js']);

// I've got my eyes on you(r file changes).
gulp.task('watch', function() {
	gulp.watch(src.js, ['js']);
	gulp.watch(src.php,['php','translate']);
	gulp.watch(src.sass,['sass']);
});

// Let's get this party started.
gulp.task('default', ['compile','translate','test','watch']);
