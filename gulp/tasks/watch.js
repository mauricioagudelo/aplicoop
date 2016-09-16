module.exports = function (gulp) {

    gulp.task('watch', function() {

        gulp.watch('./styles/**/*.scss', ['sass']);
        
    });

};