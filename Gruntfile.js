'use strict';

module.exports = function(grunt){
	grunt.initConfig({
		watch: {
			templates: {
				files: ['app/views/**/*.php'],
				options: {
					livereload: true
				}
			},
			app: {
				files: ['app/routes.php'],
				options: {
					livereload: true
				}
			},
			gruntfile: {
				files: ['Gruntfile.js']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
}