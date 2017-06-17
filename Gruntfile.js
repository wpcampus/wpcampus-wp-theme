module.exports = function(grunt) {

	// Load our dependencies
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-newer' );
	grunt.loadNpmTasks( 'grunt-phpcs' );

    var phpFiles = [
        '**/*.php',
        '!vendor/**',
        '!node_modules/**'
    ];

    grunt.initConfig({
        sass: {
            wpcampus: {
                options: {
                    style: 'compressed',
                    noCache: true,
                    sourcemap: 'none',
                    loadPath: 'bower_components/foundation/scss'
                },
                files: [{
                    expand: true,
                    src: '*.scss',
                    cwd: 'scss',
                    dest: 'css',
                    ext: '.min.css'
                }]
            }
        },
        uglify: {
            options: {
                mangle: false,
                compress: false
            },
            wpcampus: {
                files: [{
                    expand: true,
                    src: [ 'wpcampus.js', 'wpcampus-data.js' ],
                    cwd: 'js',
                    dest: 'js',
                    ext: '.min.js'
                }]
            }
        },
        watch: {
            wpcampussass: {
                files: [ 'scss/*' ],
                tasks: [ 'sass:wpcampus' ]
            },
            wpcampusjs: {
                files: [ 'js/*' ],
                tasks: [ 'newer:uglify:wpcampus' ]
            },
	        phpcs: {
		        files: phpFiles,
		        tasks: ['phpcs']
	        }
        },
        phpcs: {
            main: {
                src: phpFiles
            },
            options: {
                bin: './vendor/bin/phpcs',
                standard: 'WordPress-Core'
            }
        }
    });

    // Register our tasks
   	grunt.registerTask( 'default', [
		'newer:sass',
	    'newer:uglify',
	    'test',
	    'watch'
    ]);

	// Run tests
	grunt.registerTask( 'test', ['phpcs'] );

    // Register a watch function
    grunt.event.on( 'watch', function( action, filepath, target ) {
        grunt.log.writeln( target + ': ' + filepath + ' has ' + action );
    });

};