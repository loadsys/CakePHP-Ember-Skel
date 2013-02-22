/*global module:false*/
module.exports = function(grunt) {
  var path = require('path');
  var include = require('./include_paths');

  grunt.loadNpmTasks('grunt-mincer');

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
    appDir:    path.normalize(__dirname + '/webroot/js/app'),
    vendorDir: path.normalize(__dirname + '/webroot/js/vendor'),
    distDir:   path.normalize(__dirname + '/webroot/js/dist'),
    specsDir:  path.normalize(__dirname + '/webroot/js/specs'),
    mince: {
      app: {
        include: include,
        src: path.normalize(__dirname + '/webroot/js/app/application.js'),
        dest: path.normalize(__dirname + '/webroot/js/dist/application.js')
      },
      lib: {
        include: include,
        src: path.normalize(__dirname + '/webroot/js/app/libraries.js'),
        dest: path.normalize(__dirname + '/webroot/js/dist/libraries.js')
      }
    },
    concat: {
      setup: {
        src: [
          '<%= appDir %>/Config/setup.js',
          '<%= appDir %>/Config/store.js',
          '<%= appDir %>/Config/utilities.js'
        ],
        dest: '<%= distDir %>/setup.js'
      },
      specSetup: {
        src: [
          '<%= appDir %>/Config/setup.js',
          '<%= appDir %>/Config/spec_store.js',
          '<%= appDir %>/Config/utilities.js'
        ],
        dest: '<%= distDir %>/spec_setup.js'
      },
      specLibs: {
        src: [
          '<%= vendorDir %>/mocha.js',
          '<%= vendorDir %>/chai.js'
        ],
        dest: '<%= distDir %>/spec_libs.js'
      },
      specInit: {
        src: ['<%= appDir %>/Config/fixtures.js'],
        dest: '<%= distDir %>/spec_init.js'
      },
      specs: {
        src: ['<%= specsDir %>/**/*.js'],
        dest: '<%= distDir %>/specs.js'
      }
    },
    min: {
      libs: {
        src: ['<%= distDir %>/libraries.js'],
        dest: '<%= distDir %>/libraries.min.js'
      },
      app: {
        src: [
          '<%= distDir %>/setup.js',
          '<%= distDir %>/application.js'
        ],
        dest: '<%= distDir %>/application.min.js',
        separator: ';'
      }
    },
    watch: {
      files: '<%= appDir %>/**/*.js',
      tasks: 'mince concat'
    }
  });

  // Default task.
  grunt.registerTask('default', 'mince concat');

  // Build task.
  grunt.registerTask('build', 'mince concat min');
};
