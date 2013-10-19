'use strict';

module.exports = function(grunt){
	grunt.initConfig({
		watch: {
			templates: {
				files: ['app/views/**/*.php', 'app/markdown/**/*.md'],
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
			angularDirectives: {
				files: ['public/dashboard/directives/*.js'],
				tasks: ['concat:directives'],
			},
			angularApp: {
				files: ['public/dashboard/js/*.js', 'public/dashboard/views/**/*.html', 'public/fb.js'],
				options: {
					livereload: true
				}
			},
			compassSide: {
				files: ['public/scss/**/*.scss'],
				tasks: ['compass:dev'],
				options: {
					livereload: true
				}
			}

		},
		compass: {
			dev: {
				options: {
					sassDir: 'scss',
					cssDir: 'css',
					imagesDir: 'img/',
					httpImagesPath: '/',
					httpPath: '/',
					basePath: './public/'
				}
			}
			
		},
		concat: {
			options:{
				separator: '\n\n'
			},
			controllers: {
				options: {
					banner: grunt.file.read('public/dashboard/js/app.js') + '\n\n'
				},
				src: ['public/dashboard/controllers/*.js'],
				dest: 'public/dashboard/js/controllers.js'
			},
			services: {
				options: {
					banner: 'var services = angular.module(\'stack.feedback.services\', [\'ngResource\']); \n\n'
				},
				src: ['public/dashboard/services/*.js'],
				dest: 'public/dashboard/js/services.js'
			},
			directives: {
				options: {
					banner: 'var stack_directive = angular.module(\'stack.feedback.directives\', [\'ngResource\']); \n\n'
				},
				src: ['public/dashboard/directives/*.js'],
				dest: 'public/dashboard/js/directives.js'
			}
		},
		jshint: {
			files: ['public/dashboard/js/*.js']
		}
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-jshint');
}