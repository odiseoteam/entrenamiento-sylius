import concat from 'gulp-concat';
import gulp from 'gulp';
import gulpif from 'gulp-if';
import livereload from 'gulp-livereload';
import merge from 'merge-stream';
import order from 'gulp-order';
import sourcemaps from 'gulp-sourcemaps';
import upath from 'upath';
import uglifycss from 'gulp-uglifycss';
import uglify from 'gulp-uglify';
import yargs from 'yargs';

const { argv } = yargs.options({
  rootPath: {
    description: '<path> path to web assets directory',
    type: 'string',
    requiresArg: true,
    required: true,
  },
  nodeModulesPath: {
    description: '<path> path to node_modules directory',
    type: 'string',
    requiresArg: true,
    required: false,
  },
});

const env = process.env.GULP_ENV;
const rootPath = upath.joinSafe(upath.normalizeSafe(argv.rootPath), 'shop');
const sourcePath = upath.normalizeSafe('../source_assets/shop');
const nodeModulesPath = upath.normalizeSafe(argv.nodeModulesPath);

const paths = {
  shop: {
    js: [
      upath.joinSafe(sourcePath, 'js/**'),
    ],
    css: [
      upath.joinSafe(sourcePath, 'css/main.css'),
    ]
  }
};

const sourcePathMap = [
  {
    sourceDir: upath.relative('', nodeModulesPath),
    destPath: '/node_modules/',
  },
];

const mapSourcePath = function mapSourcePath(sourcePath) {
  const match = sourcePathMap.find(({ sourceDir }) => (
    sourcePath.substring(0, sourceDir.length) === sourceDir
  ));

  if (!match) {
    return sourcePath;
  }

  const { sourceDir, destPath } = match;

  return upath.joinSafe(destPath, sourcePath.substring(sourceDir.length));
};

export const buildShopJs = function buildShopJs() {
  return gulp.src(paths.shop.js, { base: './' })
    .pipe(gulpif(env !== 'prod', sourcemaps.init()))
    .pipe(concat('app.js'))
    .pipe(gulpif(env === 'prod', uglify()))
    .pipe(gulpif(env !== 'prod', sourcemaps.mapSources(mapSourcePath)))
    .pipe(gulpif(env !== 'prod', sourcemaps.write('./')))
    .pipe(gulp.dest(upath.joinSafe(rootPath, 'js')))
    .pipe(livereload());
};
buildShopJs.description = 'Build shop js assets.';

export const buildShopCss = function buildShopCss() {
  const cssStream = gulp.src(paths.shop.css, { base: './' })
    .pipe(gulpif(env !== 'prod', sourcemaps.init()))
    .pipe(concat('css-files.css'));

  return merge(cssStream)
    .pipe(order(['css-files.css']))
    .pipe(concat('app.css'))
    .pipe(gulpif(env === 'prod', uglifycss()))
    .pipe(gulpif(env !== 'prod', sourcemaps.mapSources(mapSourcePath)))
    .pipe(gulpif(env !== 'prod', sourcemaps.write('./')))
    .pipe(gulp.dest(upath.joinSafe(rootPath, 'css')))
    .pipe(livereload())
    ;
};
buildShopCss.description = 'Build shop css assets.';

export const watchShop = function watchShop() {
  livereload.listen();

  gulp.watch(paths.shop.js, buildShopJs);
  gulp.watch(paths.shop.css, buildShopCss);
};
watchShop.description = 'Watch shop asset sources and rebuild on changes.';

export const build = gulp.parallel(buildShopJs, buildShopCss);
build.description = 'Build assets.';

export const watch = gulp.parallel(build, watchShop);
watch.description = 'Watch asset sources and rebuild on changes.';

export default build;
