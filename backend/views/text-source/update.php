<?php

use common\models\TextTranslation;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\TextSource $model */
/** @var TextTranslation $translationModel */

$popup = isset($popup) ? $popup : false;
if (!$popup) {
  $this->title = Yii::t('backend', 'Update Text Source: {name}', [
    'name' => $model->id,
  ]);
  $this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Text Sources'), 'url' => ['index']];
  $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
  $this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
}

?>
<div class="text-source-update" id="text-source-update">
  <?php if (!$popup): ?>
    <h1><?= Html::encode($this->title) ?></h1>
  <?php endif ?>

  <div class="row">


    <div class="col-md-6 col-lg-4">
      <div class="position-sticky top-0">
        <?= Html::tag($popup ? 'h5' : 'h3', Yii::t("backend", "Source")) ?>
        <?= $this->render('_form', [
          'model' => $model,
        ]) ?>
      </div>
    </div>


    <div class="col-md-6 col-lg-4">
      <div class="position-sticky top-0">
        <?= Html::tag($popup ? 'h5' : 'h3', Yii::t("backend", "Add Translations")) ?>

        <?= $this->render(
          '../text-translation/_form.php',
          [
            'id' => $model->id,
            'model' => $translationModel,
            'submitButtonLabel' => Yii::t("backend", "Add Translation"),
          ]
        ) ?>
      </div>
    </div>


    <div class="col-md-5 col-lg-4">
      <?= Html::tag($popup ? 'h5' : 'h3', Yii::t("backend", "Translations")) ?>
      <div class="mt-4 text-translations">
        <?php foreach ($translations as $translation): ?>
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
          <!-- end card -->
        <?php endforeach ?>
      </div>
    </div>

  </div>
</div>
