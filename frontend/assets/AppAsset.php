<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css',
    'css/tailwindcss.css',
    'css/site.css',
    'css/language-picker.css',
    'css/blog.css',
    'css/styles.css',
  ];

  public $js = [
    'js/language-picker.js',
    'https://unpkg.com/htmx.org@2.0.3',
    'js/mixitup.min.js',
    'js/main.js',
  ];
}
