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
        watch: {
            wordcampus: {
                files: [ '**/*' ],
                tasks: [ 'newer:sass:wordcampus' ]
            }
        }
    });

    // Load our dependencies
    grunt.loadNpmTasks( 'grunt-contrib-sass' );
    grunt.loadNpmTasks( 'grunt-contrib-watch' );
    grunt.loadNpmTasks( 'grunt-newer' );

    // Register our tasks
   	grunt.registerTask( 'default', [ 'newer:sass', 'watch' ] );

    // Register a watch function
    grunt.event.on( 'watch', function( action, filepath, target ) {
        grunt.log.writeln( target + ': ' + filepath + ' has ' + action );
    });

};