<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\components\Utils;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\jui\JuiAsset;

AppAsset::register($this);
JuiAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
  <?php $this->beginBody() ?>


  <main role="main" class="flex-shrink-0">
    <div class="container">
      <form action="/site/language" method="post">
        <input type="hidden" value="<?= Yii::$app->request->csrfToken ?>" name="<?= Yii::$app->request->csrfParam ?>">
        <?= Html::dropDownList('language', Yii::$app->language, Utils::languages_list, [
          "onchange" => "this.parentElement.submit()",
          "class" => "form-select my-3",
        ]) ?>
      </form>
      <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      ]) ?>
      <?= Alert::widget() ?>
      <?= $content ?>
    </div>
  </main>

  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
