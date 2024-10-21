<?php

use common\components\Utils;
use yii\helpers\Url;

$exlcudedActions = ['update', 'delete', 'view', 'create'];

foreach ($controllers as $controller => $actions): ?>
  <ul>
    <?php foreach ($actions as $action): ?>
      <?php if (!in_array($action, $exlcudedActions)): ?>
        <li>
          <a href="<?= Url::to(["/" . Utils::toKebabCase($controller) . "/{$action}"]) ?>">
            <?= ucfirst($controller) ?>
            <?= $action === 'index' ? '' :  ': ' . ucfirst($action) ?>
          </a>
        <?php endif; ?>
      <?php endforeach; ?>
  </ul>
<?php endforeach; ?>
