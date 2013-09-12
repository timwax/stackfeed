'use strict';

module.exports = function(grunt){
	grunt.initConfig({
		watch: {
			templates: {
				files: ['app/views/**/*.php'],
				options: {
					livereload: true
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
}