<?php

use backend\widgets\UploadFileCard;
use common\models\CoffeeCategory;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Coffee $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="coffee-form">

  <?php $form = ActiveForm::begin(); ?>

  <div class="form-group">
    <?php if ($model->text_source_id): ?>
      <div class="d-flex justify-content-between">
        <span><?= Yii::t("backend", "Title") ?>: <?= $model->textSource->text ?></span>
        <?= Html::button(Yii::t('backend', 'Change title'), [
          'class' => 'btn btn-primary',
          'onclick' => "open('" . Url::to(['text-source/update', 'id' => $model->text_source_id, 'popup' => true]) . "', 'window', 'scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000')"
        ]) ?>
      </div>
    <?php else: ?>
      <?= $form->field($model, 'title')->textInput() ?>
    <?php endif ?>

  </div>


  <?= $form->field($model, 'price')->textInput() ?>

  <?= $form->field($model, 'category_id')->dropDownList(CoffeeCategory::toOptionList()) ?>


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


  <div class="mt-2">
    <h2 class="mb-4"><?= Yii::t('backend', 'Upload') ?></h2>
    <div class="row">
      <?= UploadFileCard::widget([
        'model' => $model,
        'upload_field' => 'image_upload',
        'image_path' => '/' . $model->image,
        'image_alt' => Yii::t('backend', 'Coffee Image'),
        'card_title' => Yii::t('backend', 'Image'),
        'form' => $form
      ]) ?>
    </div>
  </div>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
