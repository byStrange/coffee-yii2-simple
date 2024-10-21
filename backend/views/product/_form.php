<?php

use backend\widgets\UploadFileCard;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

  <?php $form = ActiveForm::begin(); ?>

  <?php if ($model->title_text_source_id): ?>
    <div class="d-flex justify-content-between">
      <span><?= Yii::t("backend", "Title") ?>: <?= $model->titleTextSource->text ?></span>
      <?= Html::button(Yii::t('backend', 'Change title'), [
        'class' => 'btn btn-primary',
        'onclick' => "open('" . Url::to(['text-source/update', 'id' => $model->title_text_source_id, 'popup' => true]) . "', 'window', 'scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000')"
      ]) ?>
    </div>
  <?php else: ?>
    <?= $form->field($model, 'title')->textInput() ?>
  <?php endif ?>

  <div class="container mt-2">
    <h2 class="mb-4"><?= Yii::t('backend', 'Image Upload') ?></h2>
    <div class="row">
      <?= UploadFileCard::widget([
        'model' => $model,
        'upload_field' => 'image_layer_1_upload',
        'image_path' => '/' . $model->image_layer_1,
        'image_alt' => Yii::t('backend', 'Layer 1'),
        'card_title' => Yii::t('backend', 'Layer 1 image'),
        'form' => $form
      ]) ?>
      <?= UploadFileCard::widget([
        'model' => $model,
        'upload_field' => 'image_layer_2_upload',
        'image_path' => '/' . $model->image_layer_2,
        'image_alt' => Yii::t('backend', 'Layer 2'),
        'card_title' => Yii::t('backend', 'Layer 2 image'),
        'form' => $form
      ]) ?>
    </div>
  </div>

  <?= $form->field($model, 'price')->textInput() ?>

  <div class="form-group">
    <?php if ($model->description_text_source_id): ?>
      <div class="d-flex justify-content-between">
        <span><?= Yii::t('backend', 'Description') ?>: <?= $model->descriptionTextSource->text ?></span>
        <?= Html::button(Yii::t('backend', 'Change description'), [
          'class' => 'btn btn-primary',
          'onclick' => "open('" . Url::to(['text-source/update', 'id' => $model->description_text_source_id, 'popup' => true]) . "', 'window', 'scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000')"
        ]) ?>
      </div>
    <?php else: ?>
      <?= $form->field($model, 'description')->textInput() ?>
    <?php endif ?>
  </div>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>
</div>
