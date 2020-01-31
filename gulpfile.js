const gulp = require("gulp");
const { series } = require('gulp');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');

function style() {
  return gulp.src('./styles/main.scss')
            .pipe(sourcemaps.init())
            .pipe(sass().on('error', sass.logError))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('./styles'));
}

function watch(){
    gulp.watch('./styles/**/*.scss', style)
}

exports.style = style;
exports.watch = watch;
exports.default = series(style, watch);
