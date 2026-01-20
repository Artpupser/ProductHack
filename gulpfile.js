import gulp from 'gulp';
import stylus from 'gulp-stylus';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import postCssImport from 'postcss-import';
import postCssNested from 'postcss-nested';
import postCssPresetEnv from 'postcss-preset-env';
import mergeRules from 'postcss-merge-rules';
import browserSync from 'browser-sync';

const server = browserSync.create();

const paths = {
    styl: {
        src: './src/public/stylus/main.styl',
        dist: './dist/public/css'
    },
    js: {
        src: './src/public/js/**/*',
        dist: './dist/public/js'
    },
    php: {
        src: ['./src/**/*.{php,ini}'],
        dist: ['./dist/'],
    },
    images: {
        src: ['./src/public/**/*.{png,jpg,jpeg,webp,svg}'],
        dist: ['./dist/public/']
    },
    fonts: {
        src: ['./src/public/fonts/**/*.{ttf,woff2,woff,otf}'],
        dist: ['./dist/public/fonts/']
    },
    scripts: {
        src: ['./src/scripts/**/*.{go,py}'],
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


gulp.task('js', function () {
    return gulp.src(paths.js.src) 
        .pipe(gulp.dest(paths.js.dist));
});

gulp.task('images', function() {
    return gulp
        .src(paths.images.src, { encoding: false }) 
        .pipe(gulp.dest(paths.images.dist)); 
});

gulp.task('storage', function(){
    return gulp
        .src(paths.storage.src, { encoding: false })
        .pipe(gulp.dest(paths.storage.dist));
})

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

gulp.task('serve', function() {
    server.init({
        port: 3001,
        proxy: "localhost:8000",
        open: false,
    });
    gulp.watch("./src/public/stylus/*.styl", gulp.series('styles'));
    gulp.watch("./src/public/js/*.js", gulp.series('js'));
    gulp.watch("./src/scripts/*.{py,go}", gulp.series('scripts'));
});

gulp.task('build', gulp.series('js', 'php', 'images', 'fonts', 'scripts', 'styles', 'serve'));
gulp.task('default', gulp.series('build'));