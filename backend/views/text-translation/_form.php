<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\TextTranslation $model */
/** @var yii\widgets\ActiveForm $form */
$submitButtonOptions = isset($submitButtonOptions) ? $submitButtonOptions : [];
?>

<div class="text-translation-form">

  <?php $form = ActiveForm::begin(isset($action) ? ['action' => $action] : []); ?>

  <?php if (isset($id)): ?>
    <?= $form->field($model, 'text_source_id')->hiddenInput(['value' => $id,])->label("") ?>
  <?php else : ?>
    <?= $form->field($model, 'text_source_id')->textInput() ?>
  <?php endif ?>


  <?= $form->field($model, 'language_code')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'translation')->textarea(['rows' => 6]) ?>

  <div class="form-group mt-2">
    <?= Html::submitButton(
      isset($submitButtonLabel) ? $submitButtonLabel : Yii::t('backend', 'Save'),
      [
        'class' => 'btn btn-success',
        ...$submitButtonOptions
      ]
    ) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
