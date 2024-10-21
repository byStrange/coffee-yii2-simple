<?php

use common\models\TextTranslation;

/** @var TextTranslation $translation */


use yii\helpers\Html;
?>

<div class="card mb-2" id="translation-<?= $translation->id ?>">
  <div class="card-body">
    <div class="d-flex align-items-center gap-2">
      <p class="text-muted text-xs m-0">language code</p>
      <h5 class="card-title mb-0"><?= $translation->language_code ?></h5>
    </div>
    <p class="card-text"><?= $translation->translation ?></p>
  </div>
  <div class="card-footer d-flex gap-2">
    <a href="/text-translation/update?id=<?= $translation->id ?>" class="btn btn-sm btn-outline-primary">Edit</a>


    <form hx-post="/text-translation/delete?ajax=true&id=<?= $translation->id ?>" hx-target="#translation-<?= $translation->id ?>" hx-swap="delete">
      <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
      <?= Html::submitButton(Yii::t('backend', 'Delete'), ['class' => 'btn btn-sm btn-outline-danger']) ?>
    </form>

  </div>
</div>
