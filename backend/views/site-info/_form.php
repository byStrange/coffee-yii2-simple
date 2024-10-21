<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SiteInfo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="site-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'phone_number')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'address')->textInput() ?>

    <?= $form->field($model, 'secondary_address')->textInput() ?>

    <?= $form->field($model, 'start_week')->textInput() ?>

    <?= $form->field($model, 'end_week')->textInput() ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?>

    <?= $form->field($model, 'facebook_url')->textInput() ?>

    <?= $form->field($model, 'instagram_url')->textInput() ?>

    <?= $form->field($model, 'telegram_url')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
