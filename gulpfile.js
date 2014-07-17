// Include gulp
var gulp = require('gulp'); 
 
// Include our plugins
// CSS tasks
var less = require('gulp-less');
var minifyCss = require('gulp-minify-css');
var prefixCss = require('gulp-autoprefixer');
// JS tasks
var uglifyJS = require('gulp-uglify');
var jshint = require('gulp-jshint');
// Various tasks
var rename = require('gulp-rename');
var liveReload = require('gulp-livereload');
var concat = require('gulp-concat');
var filesize = require('gulp-filesize');



// Compile LESS
gulp.task('less', function() {
    return gulp.src('src/less/*.less')
        .pipe(less())
        .pipe(prefixCss())
        .pipe(minifyCss())
        .pipe(filesize())
        .pipe(rename('style.css'))
        .pipe(gulp.dest('dist/css'));
});

// Vendor JS
gulp.task('vendor', function() {

    var vendorFiles = [
        'src/js/vendor/jquery.min.js',
        'src/js/vendor/jquery.ui.min.js',
        'src/js/vendor/angular.min.js',
        'src/js/vendor/angular-route.min.js',
        'src/js/vendor/angular.ui.sortable.js',
        'src/js/vendor/ng-upload.min.js',
        'src/js/vendor/ng-localstorage.js',
        'src/js/vendor/angular-animate.min.js',
        'src/js/vendor/Chart.min.js'
    ];

    return gulp.src(vendorFiles)
        .pipe(concat('vendor.min.js'))
        .pipe(uglifyJS())
        .pipe(filesize())
        .pipe(gulp.dest('dist/js'));
});

// App JS
gulp.task('scripts', function() {

    var appFiles = [
        'src/js/utils/utils.js',
        'src/js/utils/coverEditor.js',
        'src/js/application.js',
        'src/js/factories.js',
        'src/js/directives.js',
        'src/js/routes.js',
        'src/js/nav.js',
        'src/js/books.js',
        'src/js/projects.js',
        'src/js/overview.js'
    ];

    return gulp.src(appFiles)
        .pipe(jshint())
        .pipe(concat('app.min.js'))
        .pipe(uglifyJS())
        .pipe(filesize())
        .pipe(gulp.dest('dist/js'));
});

// Watch Files For Changes
gulp.task('watch', function() {

    console.log("watching ...");

    // Livereload server
    var liveServer = liveReload();

    gulp.watch('src/js/utils/*.js', ['scripts'])
    .on('change', function(event){
        liveServer.changed(event.path);
        console.log('Reloading for JS');
    });

    gulp.watch('src/js/*.js', ['scripts'])
    .on('change', function(event){
        liveServer.changed(event.path);
        console.log('Reloading for JS');
    });

    gulp.watch('src/less/*.less', ['less'])
    .on('change', function(event){
        liveServer.changed(event.path);
        console.log('Reloading for CSS');
    });

    gulp.watch(['*.html','views/*.html'])
    .on('change', function(event){
        liveServer.changed(event.path);
        console.log('Reloading for HTML');
    });
    // gulp.watch('project/*.html', ['re']);
});

// Default Task
gulp.task('default', ['less', 'scripts', 'watch']);