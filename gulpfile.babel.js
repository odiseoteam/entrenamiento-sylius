import chug from 'gulp-chug';
import gulp from 'gulp';
import yargs from 'yargs';
import upath from 'upath';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify';
import gulpif from 'gulp-if';
import cleanCSS from 'gulp-clean-css';

const env = process.env.GULP_ENV;

const { argv } = yargs
  .options({
    rootPath: {
      description: '<path> path to web assets directory',
      type: 'string',
      requiresArg: true,
      required: false,
    },
    nodeModulesPath: {
      description: '<path> path to node_modules directory',
      type: 'string',
      requiresArg: true,
      required: false,
    },
  });

const config = [
  '--rootPath',
  argv.rootPath || '../../../../../../../public/assets',
  '--nodeModulesPath',
  argv.nodeModulesPath || '../../../../../../../node_modules',
];

const appConfig = [
  '--rootPath',
  '../public/assets',
  '--nodeModulesPath',
  '../node_modules',
];

export const buildAdmin = function buildAdmin() {
  return gulp.src('vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/gulpfile.babel.js', { read: false })
    .pipe(chug({ args: config, tasks: 'build' }));
};
buildAdmin.description = 'Build admin assets.';

export const watchAdmin = function watchAdmin() {
  return gulp.src('vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/gulpfile.babel.js', { read: false })
    .pipe(chug({ args: config, tasks: 'watch' }));
};
watchAdmin.description = 'Watch admin asset sources and rebuild on changes.';

export const buildShop = function buildShop() {
  return gulp.src('vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/gulpfile.babel.js', { read: false })
    .pipe(chug({ args: config, tasks: 'build' }));
};
buildShop.description = 'Build shop assets.';

export const watchShop = function watchShop() {
  return gulp.src('vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/gulpfile.babel.js', { read: false })
    .pipe(chug({ args: config, tasks: 'watch' }));
};
watchShop.description = 'Watch shop asset sources and rebuild on changes.';

/** Custom **/
export const buildAppAdmin = function buildAppAdmin() {
  return gulp.src('gulp_tasks/admin.babel.js', { read: false })
    .pipe(chug({ args: appConfig, tasks: 'build' }));
};
buildAppAdmin.description = 'Build app admin assets.';

export const watchAppAdmin = function watchAppAdmin() {
  return gulp.src('gulp_tasks/admin.babel.js', { read: false })
    .pipe(chug({ args: appConfig, tasks: 'watch' }));
};
watchAppAdmin.description = 'Watch app admin asset sources and rebuild on changes.';

export const buildAppShop = function buildAppShop() {
  return gulp.src('gulp_tasks/shop.babel.js', { read: false })
    .pipe(chug({ args: appConfig, tasks: 'build' }));
};
buildAppShop.description = 'Build app shop assets.';

export const watchAppShop = function watchAppShop() {
  return gulp.src('gulp_tasks/shop.babel.js', { read: false })
    .pipe(chug({ args: appConfig, tasks: 'watch' }));
};
watchAppShop.description = 'Watch app shop asset sources and rebuild on changes.';


export const optimizeShopJs = function optimizeShopJs() {
  return gulp.src([
    upath.normalizeSafe('./public/assets/shop/js/app.js'),
  ])
    .pipe(concat('app.min.js'))
    .pipe(gulpif(env === 'prod', uglify()))
    .pipe(gulp.dest(upath.normalizeSafe('./public/assets/shop/js')));
};

export const optimizeShopCss = function optimizeShopCss() {
  return gulp.src([
    upath.normalizeSafe('./public/assets/shop/css/app.css'),
  ])
    .pipe(concat('app.min.css'))
    .pipe(gulpif(env === 'prod', cleanCSS({ compatibility: 'ie8' })))
    .pipe(gulp.dest(upath.normalizeSafe('./public/assets/shop/css')));
};

export const build = gulp.series(gulp.parallel(buildAdmin, buildShop, buildAppAdmin, buildAppShop), optimizeShopJs, optimizeShopCss);
build.description = 'Build assets.';

export const watch = gulp.parallel(watchAdmin, watchShop, watchAppAdmin, watchAppShop);
watch.description = 'Watch asset sources and rebuild on changes.';

gulp.task('admin', buildAdmin);
gulp.task('admin-watch', watchAdmin);
gulp.task('shop', buildShop);
gulp.task('shop-watch', watchShop);
gulp.task('app-admin', buildAppAdmin);
gulp.task('app-admin-watch', watchAppAdmin);
gulp.task('app-shop', buildAppShop);
gulp.task('app-shop-watch', watchAppShop);
gulp.task('app-optimize-shop-js', optimizeShopJs);
gulp.task('app-optimize-shop-css', optimizeShopCss);

export default build;
