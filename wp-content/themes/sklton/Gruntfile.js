module.exports = function (grunt) {
    grunt.initConfig({
        sass: {
            options: {
                style: 'compressed'
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: 'assets/scss',
                    src: ['**/*.scss', '**/*/*.scss'],
                    dest: 'assets/css',
                    ext: '.css'
                }]
            }
        },
        uglify: {
            my_target: {
                files: [{
                    expand: true,
                    cwd: 'assets/js',
                    src: ['**/*.js', '**/*/*.js', '!**/*.min.js'],
                    dest: 'assets/js',
                    rename: function (dst, src) {
                        // To keep the source js files and make new files as `*.min.js`:
                        return dst + '/' + src.replace('.js', '.min.js');
                        // Or to override to src:
                        // return src;
                    }
                }]
            }
        },
        watch: {
            options: {
                livereload: true,
            },
            scss: {
                files: ['assets/scss/*.scss', 'assets/scss/**/*.scss'],
                tasks: ['sass'],
                options: {livereload: true},
            },
            uglify: {
                files: ['assets/js/*.js', 'assets/js/**/*.js'],
                tasks: ['uglify'],
                options: {livereload: true},
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.registerTask('default', ['watch']);
    require('load-grunt-tasks')(grunt);
};
