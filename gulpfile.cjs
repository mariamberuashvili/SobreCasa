const { src, dest, watch, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass')); 
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const sourcemaps = require('gulp-sourcemaps');
const concat = require('gulp-concat');
const terser = require('gulp-terser-js');
const rename = require('gulp-rename');
const imagemin = require('gulp-imagemin');
const webp = require('gulp-webp');
const notify = require('gulp-notify');
const cache = require('gulp-cache');

const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    imagenes: 'src/img/**/*'
};


function css() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/build/css'))
        .pipe(notify({ message: 'CSS compilado' }));
}


function javascript() {
    return src(paths.js)
        .pipe(sourcemaps.init())
        .pipe(concat('bundle.js'))
        .pipe(terser())
        .pipe(rename({ suffix: '.min' }))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/build/js'))
        .pipe(notify({ message: 'JS compilado' }));
}


function imagenes() {
    return src(paths.imagenes)
        .pipe(cache(imagemin({ optimizationLevel: 5 })))
        .pipe(dest('public/build/img'))
        .pipe(notify({ message: 'Imágenes optimizadas' }));
}


function versionWebp() {
    return src(paths.imagenes)
        .pipe(webp())
        .pipe(dest('public/build/img/webp'))
        .pipe(notify({ message: 'WebP generado' }));
}


function watchArchivos() {
    watch(paths.scss, css);
    watch(paths.js, javascript);
    watch(paths.imagenes, parallel(imagenes, versionWebp));
}


exports.css = css;
exports.javascript = javascript;
exports.imagenes = imagenes;
exports.versionWebp = versionWebp;
exports.default = parallel(css, javascript, imagenes, versionWebp, watchArchivos);

