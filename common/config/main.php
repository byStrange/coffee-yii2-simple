<?php

use app\components\LanguageSelector;

return [
  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm'   => '@vendor/npm-asset',
  ],
  'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
  'components' => [
    'cache' => [
      'class' => \yii\caching\FileCache::class,
    ],
    'i18n' => [
      'translations' => [
        'common*' => [
          'class' => 'yii\i18n\PhpMessageSource',
          'sourceLanguage' => 'en',
          'basePath' => '@common/messages',
        ],
      ]
    ],
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false
    ]
  ],
];
