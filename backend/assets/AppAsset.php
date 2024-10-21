<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/site.css',
  ];
  public $js = [
    'https://unpkg.com/htmx.org@2.0.3',
  ];
  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap5\BootstrapAsset',
  ];
}
