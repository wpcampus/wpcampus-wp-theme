// Require all the things (that we need)
var gulp = require('gulp');
var watch = require('gulp-watch');
var minify = require('gulp-minify');
var sass = require('gulp-sass');
var rename = require("gulp-rename");
var autoprefixer = require('gulp-autoprefixer');
var normalize = require('node-normalize-scss').includePaths;
var bourbon = require('bourbon').includePaths;
var neat = require('bourbon-neat').includePaths;
var phpcs = require('gulp-phpcs');

// Define our SASS includes
var sassIncludes = [].concat(normalize, bourbon, neat);

// Define the source paths for each file type
var src = {
    scss: ['assets/scss/**/*','!assets/scss/components'],
	js: ['assets/js/eduwapuu.js','assets/js/wpcampus.js','assets/js/wpcampus-data.js'],
	php: ['**/*.php','!vendor/**','!node_modules/**']
};

// Define the destination paths for each file type
var dest = {
	scss: 'assets/css',
	js: 'assets/js'
};

// Sass is pretty awesome, right?
gulp.task('sass', function() {
    return gulp.src(src.scss)
        .pipe(sass({
			includePaths: sassIncludes,
			outputStyle: 'compressed'
		})
		.on('error', sass.logError))
        .pipe(autoprefixer({
        	browsers: ['last 2 versions'],
			cascade: false
		}))
	    .pipe(rename({
	    	suffix: '.min'
	    }))
		.pipe(gulp.dest(dest.scss));
});

// We don't need this... yet
gulp.task('js', function() {
    gulp.src(src.js)
        .pipe(minify({
            mangle: false,
	        ext:{
		        min:'.min.js'
	        }
        }))
        .pipe(gulp.dest(dest.js))
});

// Sniff our code
gulp.task('php', function () {
	return gulp.src(src.php)
		.pipe(phpcs({
			standard: 'WordPress-Core'
		}))
		// Log all problems that was found
		.pipe(phpcs.reporter('log'));
});

// Let's get this party started
gulp.task('default',[
	'compile',
	'watch'
]);

// Compile all the things
gulp.task('compile',[
	'sass',
	'js'
]);

// I've got my eyes on you(r file changes)
gulp.task('watch', function() {
	gulp.watch(src.scss, ['sass']);
	gulp.watch(src.js, ['js']);
	gulp.watch(src.php, ['php']);
});