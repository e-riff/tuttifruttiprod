const Encore = require('@symfony/webpack-encore');

// Configure toujours l’environnement (utile en CI ou production)
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'production');
}

Encore
    // 1) Dossier de sortie
    .setOutputPath('public/build/')
    // 2) Chemin public utilisé par Apache/nginx
    .setPublicPath('/build')

    // 3) Copie tes images/static avant build
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]'
    })

    // 4) Ton entry principale
    .addEntry('app', './assets/app.js')

    // 5) Symfony UX Stimulus (si besoin)
    .enableStimulusBridge('./assets/controllers.json')

    // 6) Optimisations : split des chunks + runtime séparé
    .splitEntryChunks()
    .enableSingleRuntimeChunk()

    // 7) Nettoyage du dossier public/build avant chaque build
    .cleanupOutputBeforeBuild()

    // 8) Notifications desktop (optionnel)
    .enableBuildNotifications()

    // 9) Sourcemaps uniquement hors production
    .enableSourceMaps(!Encore.isProduction())

    // 10) Hash dans le nom de fichier en production (app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // 11) Babel : polyfills “usage” + core-js v3
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // 12) Support SCSS/Sass
    .enableSassLoader()

// … tu peux décommenter si tu utilises TS/React/jQuery, etc.
;

// Exporte la config finale
module.exports = Encore.getWebpackConfig();
