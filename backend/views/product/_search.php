<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\ProductSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-search">

  <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => [
      'data-pjax' => 1
    ],
  ]); ?>

  <?= $form->field($model, 'id') ?>

  <?= $form->field($model, 'title_text_source_id') ?>

  <?= $form->field($model, 'image_layer_1') ?>

  <?= $form->field($model, 'image_layer_2') ?>

  <?= $form->field($model, 'price') ?>

  <?php // echo $form->field($model, 'description_text_source_id') 
  ?>

  <?php // echo $form->field($model, 'created_at') 
  ?>

  <?php // echo $form->field($model, 'updated_at') 
  ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
