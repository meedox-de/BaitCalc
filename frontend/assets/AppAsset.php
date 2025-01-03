<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [
        'css/site.css',
        'css/GridViewResponsive.css',
    ];
    public $js       = [
        'js/GridViewSearchBar.js',
    ];
    public $depends  = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
