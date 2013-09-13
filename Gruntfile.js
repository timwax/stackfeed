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
			},
			angularControllers: {
				files: ['public/dashboard/controllers/*.js'],
				tasks: ['concat:controllers'],
			},			
			angularServices: {
				files: ['public/dashboard/services/*.js'],
				tasks: ['concat:services'],
			},
			angularApp: {
				files: ['public/dashboard/js/*.js', 'public/dashboard/views/**/*.html'],
				options: {
					livereload: true
				}
			}

		},
		concat: {
			options: {
				separator: '\n\n'
			},
			controllers: {
				src: ['public/dashboard/controllers/*.js'],
				dest: 'public/dashboard/js/controllers.js'
			},
			services: {
				src: ['public/dashboard/services/*.js'],
				dest: 'public/dashboard/js/services.js'
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
}