<?php

use backend\widgets\UploadFileCard;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Sponsor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sponsor-form">

  <?php $form = ActiveForm::begin(); ?>

  <div class="container mt-2">
    <h2 class="mb-4"><?= Yii::t('backend', 'Image Upload') ?></h2>
    <div class="row">
      <?= UploadFileCard::widget([
        'model' => $model,
        'upload_field' => 'image_path_upload',
        'image_path' => '/' . $model->image_path,
        'image_alt' => Yii::t('backend', 'Image'),
        'card_title' => Yii::t('backend', 'Image'),
        'form' => $form
      ]) ?>
    </div>
  </div>
  <?= $form->field($model, 'name')->textInput() ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
