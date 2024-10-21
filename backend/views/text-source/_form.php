<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\TextSource $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="text-source-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

  <div class="form-group mt-2">
    <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
