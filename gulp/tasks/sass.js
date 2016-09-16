var sass = require('gulp-sass'),  
    sourcemaps = require('gulp-sourcemaps');


module.exports = function (gulp) {

    gulp.task('sass', function () {
        return gulp.src('./styles/main.scss')
            .pipe(sourcemaps.init())
            .pipe(sass().on('error', sass.logError))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('./styles'));
    });

};