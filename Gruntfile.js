module.exports = function(grunt) {

    grunt.initConfig({
        sass: {
            wordcampus: {
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
            wordcampus: {
                files: [{
                    expand: true,
                    src: [ 'wpcampus.js', 'wordcampus-data.js' ],
                    cwd: 'js',
                    dest: 'js',
                    ext: '.min.js'
                }]
            }
        },
        watch: {
            wordcampussass: {
                files: [ 'scss/*' ],
                tasks: [ 'sass:wordcampus' ]
            },
            wordcampusjs: {
                files: [ 'js/*' ],
                tasks: [ 'newer:uglify:wordcampus' ]
            }
        }
    });

    // Load our dependencies
    grunt.loadNpmTasks( 'grunt-contrib-sass' );
    grunt.loadNpmTasks( 'grunt-contrib-watch' );
    grunt.loadNpmTasks( 'grunt-contrib-uglify' );
    grunt.loadNpmTasks( 'grunt-newer' );

    // Register our tasks
   	grunt.registerTask( 'default', [ 'newer:sass', 'newer:uglify', 'watch' ] );

    // Register a watch function
    grunt.event.on( 'watch', function( action, filepath, target ) {
        grunt.log.writeln( target + ': ' + filepath + ' has ' + action );
    });

};