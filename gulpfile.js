'use strict';

const gulp = require('gulp');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify');
const rename = require("gulp-rename");
const argv = require('yargs').choices('m', ['home', 'admin']).default('m', 'home').argv;

gulp.task('css', () => {
    let path = `static/${argv.m}/style/`;
    gulp.src([`${path}*.css`, `!${path}*.min.css`], { base: './' })
        .pipe(autoprefixer({
            browsers: ['> 1%', 'last 10 versions'],
            cascade: false
        }))
        .pipe(cleanCSS({
            compatibility: 'ie8'
        }))
        .pipe(rename({
            suffix: ".min"
        }))
        .pipe(gulp.dest('./'));
});

gulp.task('js', () => {
    let path = `static/${argv.m}/js/`;
    gulp.src([`${path}*.js`, `!${path}*.min.js`], { base: './' })
        .pipe(uglify())
        .pipe(rename({
            suffix: ".min"
        }))
        .pipe(gulp.dest('./'));
});

gulp.task('default', () => {
    console.log('------------------');
    console.log('css');
    console.log('css --m=admin');
    console.log('js');
    console.log('js --m=admin');
    console.log('------------------');
});