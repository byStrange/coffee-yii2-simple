<?php

use backend\widgets\UploadFileCard;
use yii\helpers\Html;
use kartik\editors\Summernote;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Blog $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="blog-form">

  <?php $form = ActiveForm::begin(); ?>

  <?php if ($model->title_text_source_id): ?>
    <div class="d-flex justify-content-between">
      <span><?= Yii::t("backend", "Title") ?>: <?= $model->titleTextSource->getText() ?></span>
      <?= Html::button(Yii::t('backend', 'Change title'), [
        'class' => 'btn btn-primary',
        'onclick' => "open('" . Url::to(['text-source/update', 'id' => $model->title_text_source_id, 'popup' => true]) . "', 'window', 'scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000')"
      ]) ?>
    </div>
  <?php else: ?>
    <?= $form->field($model, 'title')->textInput() ?>
  <?php endif ?>

  <div class="mt-2">
    <?php if ($model->highlighted_text_source_id): ?>
      <div class="d-flex justify-content-between">
        <span><?= Yii::t("backend", "Highlighted Text") ?>: <?= $model->highlightedTextSource->getText() ?></span>
        <?= Html::button(Yii::t('backend', 'Change highlighted text'), [
          'class' => 'btn btn-primary',
          'onclick' => "open('" . Url::to(['text-source/update', 'id' => $model->title_text_source_id, 'popup' => true]) . "', 'window', 'scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000')"
        ]) ?>
      </div>
    <?php else: ?>
      <?= $form->field($model, 'highlighted_text')->textarea() ?>
    <?php endif ?>

  </div>
  <div class="container mt-2">
    <h2 class="mb-4"><?= Yii::t('backend', 'Image Upload') ?></h2>
    <div class="row">
      <?= UploadFileCard::widget([
        'model' => $model,
        'upload_field' => 'main_image_upload',
        'image_path' => '/' . $model->main_image,
        'image_alt' => Yii::t('backend', 'Main Image'),
        'card_title' => Yii::t('backend', 'Main Image'),
        'form' => $form
      ]) ?>
      <?= UploadFileCard::widget([
        'model' => $model,
        'upload_field' => 'thumbnail_image_upload',
        'image_path' => '/' . $model->thumbnail_image,
        'image_alt' => Yii::t('backend', 'Thumbnail Image'),
        'card_title' => Yii::t('backend', 'Thumbnail Image'),
        'form' => $form
      ]) ?>
    </div>
  </div>


  <?= $form->field($model, 'body')->widget(Summernote::class, []) ?>

  <?= $form->field($model, 'status')->textInput() ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
