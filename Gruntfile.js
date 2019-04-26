module.exports = function(grunt) {
	grunt.initConfig({
	  	paths: {
	  		bower_components: 'bower_components',
	  		Assets: 'Assets'
	  	},
	  	copy: {
	  		js: {
	  			files: [
	  				{
	  					expand: true,
	  					cwd: '<%= paths.bower_components %>',
	  					src: '*/dist/**.js',
	  					dest: '<%= paths.Assets %>/js'
	  				},
	  				{
	  					expand: true,
	  					cwd: '<%= paths.bower_components %>',
	  					src: '*/**.js',
	  					dest: '<%= paths.Assets %>/js'
	  				},
	  				{
	  					expand: true,
	  					cwd: '<%= paths.bower_components %>',
	  					src: '*/lib/**.js',
	  					dest: '<%= paths.Assets %>/js'
	  				},
	  				{
	  					expand: true,
	  					cwd: '<%= paths.bower_components %>',
	  					src: 'squire-rte/source/**.js',
	  					dest: '<%= paths.Assets %>/js'
	  				}
	  			]
	  		},
	  		css: {
	  			files: [
	  				{
	  					expand: true,
	  					cwd: '<%= paths.bower_components %>',
	  					src: '*/dist/**.css',
	  					dest: '<%= paths.Assets %>/css'
	  				},
	  				{
	  					expand: true,
	  					cwd: '<%= paths.bower_components %>',
	  					src: '*/**.css',
	  					dest: '<%= paths.Assets %>/css'
	  				},
	  				{
	  					expand: true,
	  					cwd: '<%= paths.bower_components %>',
	  					src: '*/lib/**.css',
	  					dest: '<%= paths.Assets %>/css'
	  				},
	  				{
	  					expand: true,
	  					cwd: '<%= paths.bower_components %>',
	  					src: 'squire-rte/source/**.css',
	  					dest: '<%= paths.Assets %>/css'
	  				}
	  			]
	  		}
	  	}
	});
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.registerTask('default', ['copy']);
}