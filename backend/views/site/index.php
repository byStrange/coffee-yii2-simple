<?php

/** @var yii\web\View $this */

use backend\widgets\ControllerNavigatorWidget;

$this->title = 'My Yii Application';
?>

<?= ControllerNavigatorWidget::widget([
  'exclude' => ['site/index', 'site/login', 'site/logout', 'site/signup', 'text-source/index', 'text-translation/index'],
]) ?>
