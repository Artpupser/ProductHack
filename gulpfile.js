import gulp from 'gulp';
import stylus from 'gulp-stylus';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import postCssImport from 'postcss-import';
import postCssNested from 'postcss-nested';
import postCssPresetEnv from 'postcss-preset-env';
import mergeRules from 'postcss-merge-rules';

const paths = {
    styl: {
        src: './src/public/stylus/main.styl',
        dist: './dist/public/css'
    },
    css: {
        src: './src/public/css/**/*.css',
        dist: './dist/public/css'
    },
    php: {
        src: ['./src/**/*.php'],
        dist: ['./dist/'],
    },
    images: {
        src: ['./src/assets/**/*.{png,jpg,jpeg,webp,svg}'],
        dist: ['./dist/assets/']
    },
    fonts: {
        src: ['./src/assets/fonts/**/*.ttf'],
        dist: ['./dist/assets/fonts/']
    },
    scripts: {
        src: ['./src/scripts/**/*.{go, py}'],
        dist: ['./dist/scripts/']
    }
};

gulp.task('styles', function () {
    return gulp.src(paths.styl.src) 
        .pipe(stylus()) 
        .pipe(postcss([
            postCssImport(),
            postCssNested(),
            postCssPresetEnv({stage: 0}), //0 - эксперементал, 1 - продакшн
            autoprefixer(),
            mergeRules(),
            cssnano({preset: 'default'})])) 
        .pipe(gulp.dest(paths.styl.dist)); 
});

gulp.task('css', function () {
    return gulp.src(paths.css.src) 
        .pipe(gulp.dest(paths.css.dist)); 
});


gulp.task('images', function() {
    return gulp
        .src(paths.images.src, { encoding: false }) 
        .pipe(gulp.dest(paths.images.dist)); 
});


gulp.task('fonts', function(){
    return gulp
        .src(paths.fonts.src, { encoding: false })
        .pipe(gulp.dest(paths.fonts.dist));
})

gulp.task('scripts', function () {
    return gulp.src(paths.scripts.src)
        .pipe(gulp.dest(paths.scripts.dist));
});


gulp.task('php', function () {
    return gulp.src(paths.php.src)
        .pipe(gulp.dest(paths.php.dist));
});



gulp.task('build', gulp.series('php','images', 'fonts', 'css', 'fonts', 'scripts'));
gulp.task('default', gulp.series('build'));