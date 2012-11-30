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
    concat: {
      libs: {
        src: [
          'webroot/js/vendor/jquery-1.8.3.js',
          'webroot/js/vendor/ember.js',
          'webroot/js/vendor/ember-data.js',
          'webroot/js/vendor/handlebars-1.0.rc.1.js'
        ],
        dest: 'webroot/js/dist/libraries.js'
      }
    },
    min: {
      libs: {
        src: ['webroot/js/dist/libraries.js'],
        dest: 'webroot/js/dist/libraries.min.js'
      }
    },
    watch: {
      files: 'webroot/js/app/**/*.js',
      tasks: 'concat'
    },
    uglify: {}
  });

  // Default task.
  grunt.registerTask('default', 'concat min');

};
