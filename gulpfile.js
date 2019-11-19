var gulp = require('gulp');
var rename = require('gulp-rename');
var babel = require("gulp-babel");


gulp.task('build-MarkdownConvertor',function(done) {
	return gulp.src('js/src/MarkdownConvertor/MarkdownConvertor.js')
	    .pipe(babel())
	    .pipe(gulp.dest('js/src/MarkdownConvertor/dist'));
});

gulp.task('build',gulp.parallel('build-MarkdownConvertor'));

gulp.task('copy-js', gulp.series('build',function(done) {
	gulp.src('bower_components/codemirror/lib/**.js')
	    .pipe(gulp.dest('Assets/js/codemirror/'));
	gulp.src('bower_components/eve/**.js')
	    .pipe(gulp.dest('Assets/js/eve/'));
	gulp.src('bower_components/highlightjs/**.js')
	    .pipe(gulp.dest('Assets/js/highlightjs/'));
	gulp.src('bower_components/jquery/dist/**.js')
	    .pipe(gulp.dest('Assets/js/jquery/'));
	gulp.src('bower_components/katex/dist/**.js')
	    .pipe(gulp.dest('Assets/js/katex/'));
	gulp.src('bower_components/markdown-it/dist/**.js')
	    .pipe(gulp.dest('Assets/js/markdown-it/'));
	gulp.src('bower_components/raphael/**.js')
	    .pipe(gulp.dest('Assets/js/raphael/'));
	gulp.src('bower_components/squire-rte/source/**.js')
	    .pipe(gulp.dest('Assets/js/squire-rte/'));
	gulp.src('bower_components/to-mark/dist/**.js')
	    .pipe(gulp.dest('Assets/js/to-mark/'));
	gulp.src('js/src/MarkdownConvertor/dist/**.js')
	    .pipe(gulp.dest('js/'));
	done();
}));

gulp.task('Copy-MathJax',gulp.series('build',function(done) {
	gulp.src('bower_components/MathJax/unpacked/**')
	    .pipe(gulp.dest('Assets/MathJax/'));
	done();
}));

gulp.task('copy-css', gulp.series('build',function(done) {
	gulp.src('bower_components/codemirror/lib/**.css')
	    .pipe(gulp.dest('Assets/css/codemirror/'));
	gulp.src('bower_components/eve/**.css')
	    .pipe(gulp.dest('Assets/css/eve/'));
	gulp.src('bower_components/highlightjs/**.css')
	    .pipe(gulp.dest('Assets/css/highlightjs/'));
	gulp.src('bower_components/jquery/dist/**.css')
	    .pipe(gulp.dest('Assets/css/jquery/'));
	gulp.src('bower_components/katex/dist/**.css')
	    .pipe(gulp.dest('Assets/css/katex/'));
	gulp.src('bower_components/markdown-it/dist/**.css')
	    .pipe(gulp.dest('Assets/css/markdown-it/'));
	gulp.src('bower_components/raphael/**.css')
	    .pipe(gulp.dest('Assets/css/raphael/'));
	gulp.src('bower_components/squire-rte/source/**.css')
	    .pipe(gulp.dest('Assets/css/squire-rte/'));
	gulp.src('bower_components/to-mark/dist/**.css')
	    .pipe(gulp.dest('Assets/css/to-mark/'));
	done();
}));

gulp.task('default', gulp.parallel('copy-js','copy-css','Copy-MathJax'));