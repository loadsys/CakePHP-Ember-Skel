/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: '<json:package.json>',
    meta: {
      banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
        '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
        '<%= pkg.homepage ? "* " + pkg.homepage + "\n" : "" %>' +
        '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
        ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */'
    },
    appDir:    'webroot/js/app',
    vendorDir: 'webroot/js/vendor',
    distDir:   'webroot/js/dist',
    specsDir:   'webroot/js/specs',
    concat: {
      setup: {
        src: ['<%= appDir %>/Config/setup.js'],
        dest: '<%= distDir %>/setup.js'
      },
      specSetup: {
        src: ['<%= appDir %>/Config/spec_setup.js'],
        dest: '<%= distDir %>/spec_setup.js'
      },
      libs: {
        src: [
          '<%= vendorDir %>/jquery-1.8.3.js',
          '<%= vendorDir %>/handlebars-1.0.0.beta.6.js',
          '<%= vendorDir %>/ember-1.0.0-pre.2.js',
          '<%= vendorDir %>/ember-data.js'
        ],
        dest: '<%= distDir %>/libraries.js'
      },
      specLibs: {
        src: [
          '<%= vendorDir %>/mocha.js',
          '<%= vendorDir %>/chai.js'
        ],
        dest: '<%= distDir %>/spec_libs.js'
      },
      init: {
        src: [
          '<%= appDir %>/Config/initialize.js',
          '<%= appDir %>/Config/seed.js'
        ],
        dest: '<%= distDir %>/initialize.js'
      },
      app: {
        src: [
          '<%= appDir %>/Model/*.js',
          '<%= appDir %>/Controller/ApplicationController.js',
          '<%= appDir %>/View/ApplicationView.js',
          '<%= appDir %>/Route/ApplicationRoute.js',
          // The router.js must be last
          '<%= appDir %>/Config/router.js'
        ],
        dest: '<%= distDir %>/application.js'
      },
      specs: {
        src: ['<%= specsDir %>/**/*.js'],
        dest: '<%= distDir %>/specs.js'
      }
    },
    min: {
      setup: {
        src: ['<%= distDir %>/setup.js'],
        dest: '<%= distDir %>/setup.min.js'
      },
      specSetup: {
        src: ['<%= distDir %>/spec_setup.js'],
        dest: '<%= distDir %>/spec_setup.min.js'
      },
      libs: {
        src: ['<%= distDir %>/libraries.js'],
        dest: '<%= distDir %>/libraries.min.js'
      },
      specLibs: {
        src: ['<%= distDir %>/spec_libs.js'],
        dest: '<%= distDir %>/spec_libs.min.js'
      },
      init: {
        src: ['<%= distDir %>/initialize.js'],
        dest: '<%= distDir %>/initialize.min.js'
      },
      app: {
        src: ['<%= distDir %>/application.js'],
        dest: '<%= distDir %>/application.min.js'
      },
      specs: {
        src: ['<%= distDir %>/specs.js'],
        dest: '<%= distDir %>/specs.min.js'
      }
    },
    watch: {
      files: '<%= appDir %>/**/*.js',
      tasks: 'concat'
    },
    uglify: {}
  });

  // Default task.
  grunt.registerTask('default', 'concat min');

};
