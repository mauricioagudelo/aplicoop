var gulp = require('gulp');


require('./gulp/tasks/sass.js')(gulp);
require('./gulp/tasks/watch.js')(gulp);

gulp.task('default', ['watch']);

