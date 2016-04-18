/*!
 * Bootstrap's Gruntfile
 * http://getbootstrap.com
 * Copyright 2013-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

module.exports = function (grunt) {
  'use strict';

  // Force use of Unix newlines
  grunt.util.linefeed = '\n';

  RegExp.quote = function (string) {
    return string.replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&');
  };

  var fs = require('fs');
  var path = require('path');
  var npmShrinkwrap = require('npm-shrinkwrap');
  var generateGlyphiconsData = require('./grunt/bs-glyphicons-data-generator.js');
  var BsLessdocParser = require('./grunt/bs-lessdoc-parser.js');
  var getLessVarsData = function () {
    var filePath = path.join(__dirname, 'less/variables.less');
    var fileContent = fs.readFileSync(filePath, { encoding: 'utf8' });
    var parser = new BsLessdocParser(fileContent);
    return { sections: parser.parseFile() };
  };
  var generateRawFiles = require('./grunt/bs-raw-files-generator.js');
  var generateCommonJSModule = require('./grunt/bs-commonjs-generator.js');
  var configBridge = grunt.file.readJSON('./grunt/configBridge.json', { encoding: 'utf8' });

  Object.keys(configBridge.paths).forEach(function (key) {
    configBridge.paths[key].forEach(function (val, i, arr) {
      arr[i] = path.join('./docs/assets', val);
    });
  });

  // Project configuration.
  grunt.initConfig({

    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*!\n' +
            ' * Project Pamerin v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
            ' * Copyright 2016-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
            ' * Licensed under the <%= pkg.license %> license\n' +
            ' */\n',
    jqueryCheck: configBridge.config.jqueryCheck.join('\n'),
    jqueryVersionCheck: configBridge.config.jqueryVersionCheck.join('\n'),

    // Task configuration.
    clean: {
      dist: '../assets'
    },

    jshint: {
      options: {
        jshintrc: 'js/.jshintrc'
      },
      grunt: {
        options: {
          jshintrc: 'grunt/.jshintrc'
        },
        src: ['Gruntfile.js', 'package.js', 'grunt/*.js']
      },
      core: {
        src: 'js/*.js'
      },
    },

    jscs: {
      options: {
        config: 'js/.jscsrc'
      },
      grunt: {
        src: '<%= jshint.grunt.src %>'
      },
      core: {
        src: '<%= jshint.core.src %>'
      },
      test: {
        src: '<%= jshint.test.src %>'
      },
      assets: {
        options: {
          requireCamelCaseOrUpperCaseIdentifiers: null
        },
        src: '<%= jshint.assets.src %>'
      }
    },

    concat: {
      options: {
        banner: '<%= banner %>\n<%= jqueryCheck %>\n<%= jqueryVersionCheck %>',
        stripBanners: false
      },
      bootstrap: {
        src: [
          'js/transition.js',
          'js/alert.js',
          'js/button.js',
          //'js/carousel.js',
          'js/collapse.js',
          'js/dropdown.js',
          'js/modal.js',
          //'js/tooltip.js',
          //'js/popover.js',
          //'js/scrollspy.js',
          'js/tab.js',
          'js/affix.js'
        ],
        dest: '../assets/js/<%= pkg.name %>.js'
      }
    },

    uglify: {
      options: {
        compress: {
          warnings: false
        },
        mangle: true,
        preserveComments: 'some'
      },
      core: {
        src: '<%= concat.bootstrap.dest %>',
        dest: '../assets/js/<%= pkg.name %>.min.js'
      },
      app: {
      	options: {
	      banner: 	'/*!\n' +
	        		' * Project Pamerin v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
			        ' * Copyright 2016-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
			        ' * Licensed under the <%= pkg.license %> license\n' +
			        ' */\n'
		},
	      files: [{
	            expand: true,
	            src: '*.js',
	            dest: '../assets/js',
	            cwd: 'js/system',
	        ext: '.min.js'
	        }]
      },
      customize: {
        src: configBridge.paths.customizerJs,
        dest: 'docs/assets/js/customize.min.js'
      },
      docsJs: {
        src: configBridge.paths.docsJs,
        dest: 'docs/assets/js/docs.min.js'
      }
    },


    less: {
      compileCore: {
        options: {
	      banner: 	'/*!\n' +
	        		' * Project Pamerin v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
			        ' * Copyright 2016-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
			        ' * Licensed under the <%= pkg.license %> license\n' +
			        ' */\n',
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: '<%= pkg.name %>.css.map',
          sourceMapFilename: '../assets/css/<%= pkg.name %>.css.map'
        },
        src: 'less/bootstrap.less',
        dest: '../assets/css/<%= pkg.name %>.css'
      }
    },

    autoprefixer: {
      options: {
        browsers: configBridge.config.autoprefixerBrowsers
      },
      core: {
        options: {
          map: true
        },
        src: '../assets/css/<%= pkg.name %>.css'
      }
    },

    csslint: {
      options: {
        csslintrc: 'less/.csslintrc'
      },
      dist: [
        '../assets/css/<%= pkg.name %>.css'
      ]
    },

    cssmin: {
      options: {
        // TODO: disable `zeroUnits` optimization once clean-css 3.2 is released
        //    and then simplify the fix for https://github.com/twbs/bootstrap/issues/14837 accordingly
        compatibility: 'ie8',
        keepSpecialComments: true,
        sourceMap: true,
        advanced: false
      },
      minifyCore: {
        src: '../assets/css/<%= pkg.name %>.css',
        dest: '../assets/css/<%= pkg.name %>.min.css'
      }
    },

    csscomb: {
      options: {
        config: 'less/.csscomb.json'
      },
      dist: {
        expand: true,
        cwd: '../assets/css/',
        src: ['*.css', '!*.min.css'],
        dest: '../assets/css/'
      }
    },

    copy: {
      fonts: {
        expand: true,
        src: 'fonts/*',
        dest: '../assets/'
      },
      plugin:{
      	expand: true,
      	cwd: 'plugins',
      	src: '**',
      	dest: '../assets/plugins/'
      },
      app:{
      	expand: true,
      	cwd: 'js/system',
      	src: '*.js',
      	dest: '../assets/js'
      }
    },

    connect: {
      server: {
        options: {
          port: 3000,
          base: '.'
        }
      }
    },
    // Optimize images
    image: {
      dynamic: {
        files: [{
          expand: true,
          cwd: 'img/',
          src: ['**/*.{png,jpg,gif,svg,jpeg}'],
          dest: '../assets/img/'
        }]
      }
    },


    watch: {
      src: {
        files: ['<%= jshint.core.src %>','js/system/*.js'],
        tasks: ['jshint:core', 'concat','uglify:app','copy:app']
      },
      less: {
        files: 'less/**/*.less',
        tasks: ['less','cssmin:minifyCore']
      },
      img:{
	    files: ["img/**.{png,jpg,gif,svg,jpeg}"],
	    tasks: ["image"]
	  }
    },

    sed: {
      versionNumber: {
        pattern: (function () {
          var old = grunt.option('oldver');
          return old ? RegExp.quote(old) : old;
        })(),
        replacement: grunt.option('newver'),
        exclude: [
          '../assets/fonts',
          'docs/assets',
          'fonts',
          'js/tests/vendor',
          'node_modules',
          'test-infra'
        ],
        recursive: true
      }
    },


    exec: {
      npmUpdate: {
        command: 'npm update'
      }
    },

  });


  // These plugins provide necessary tasks.
  require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });
  require('time-grunt')(grunt);

  
  // JS distribution task.
  grunt.registerTask('dist-js', ['concat', 'uglify:core', 'commonjs','uglify:app']);

  // CSS distribution task.
  grunt.registerTask('less-compile', ['less:compileCore']);
  grunt.registerTask('dist-css', ['less-compile', 'autoprefixer:core', 'csscomb:dist', 'cssmin:minifyCore']);

  // Full distribution task.
  grunt.registerTask('dist', ['clean:dist', 'dist-css', 'copy:fonts','copy:plugin','copy:app', 'uglify:app', 'dist-js',"image"]);

  // Default task.
  grunt.registerTask('default', ['clean:dist', 'copy:fonts','copy:plugin','image']);
  // Optimize images
  grunt.loadNpmTasks('grunt-image');

  // Version numbering task.
  // grunt change-version-number --oldver=A.B.C --newver=X.Y.Z
  // This can be overzealous, so its changes should always be manually reviewed!
  grunt.registerTask('change-version-number', 'sed');

  grunt.registerTask('build-glyphicons-data', function () { generateGlyphiconsData.call(this, grunt); });

  
  grunt.registerTask('commonjs', 'Generate CommonJS entrypoint module in dist dir.', function () {
    var srcFiles = grunt.config.get('concat.bootstrap.src');
    var destFilepath = '../assets/js/npm.js';
    generateCommonJSModule(grunt, srcFiles, destFilepath);
  });
};
