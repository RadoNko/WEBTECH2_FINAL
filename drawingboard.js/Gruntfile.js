module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	grunt.initConfig({
		bwr: grunt.file.readJSON('bower.json'),
		meta: {
			banner: "/* <%= bwr.name %> v<%= bwr.version %> - https://github.com/Leimi/drawingboard.js\n" +
			"* Copyright (c) <%= grunt.template.today('yyyy') %> Emmanuel Pelletier\n" +
			'* Licensed MIT */\n'
		},

		concat: {
			options: {
				banner: "<%= meta.banner %>"
			},
			light: {
				src: [
					'bower_components/simple-undo/lib/simple-undo.js',
					'js/utils.js',
					'js/board.js'
				],
				dest: 'drawingboard.js/drawingboard.nocontrol.js'
			},
			full: {
				src: ['bower_components/simple-undo/lib/simple-undo.js', 'js/utils.js', 'js/board.js', 'js/controls/control.js', 'js/controls/color.js', 'js/controls/drawingmode.js', 'js/controls/navigation.js', 'js/controls/size.js', 'js/controls/download.js'],
				dest: 'drawingboard.js/drawingboard.js'
			},
			cssLight: { //simple copy in order to have everything in drawingboard.js/
				src: ['css/drawingboard.nocontrol.css'],
				dest: 'drawingboard.js/drawingboard.nocontrol.css'
			},
			cssFull: { //simple copy in order to have everything in drawingboard.js/
				src: ['css/drawingboard.css'],
				dest: 'drawingboard.js/drawingboard.css'
			}
		},

		uglify: {
			options: {
				banner: "<%= meta.banner %>",
				report: "gzip"
			},
			light: {
				files: {
					'dist/drawingboard.nocontrol.min.js': ['drawingboard.js/drawingboard.nocontrol.js']
				}
			},
			full: {
				files: {
					'dist/drawingboard.min.js': ['drawingboard.js/drawingboard.js']
				}
			}
		},

		cssmin: {
			options: {
				banner: "<%= meta.banner %>"
			},
			light: {
				files: {
					'dist/drawingboard.nocontrol.min.css': ['css/drawingboard.nocontrol.css']
				}
			},
			full: {
				files: {
					'dist/drawingboard.min.css': ['css/drawingboard.css']
				}
			}
		}
	});

	grunt.registerTask('default', ['concat', 'uglify', 'cssmin']);
};
