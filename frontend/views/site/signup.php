<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
$this->registerAssetBundle('yii\bootstrap5\BootstrapAsset');

$this->registerAssetBundle('yii\jui\JuiAsset');
?>

<div class="container mt-3">

  <div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
      <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group" style="display: flex; gap: 12px; align-items: center;">
          <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>

          <?= Html::a('Login', ['/site/login'], ['class' => 'btn-link']) ?>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>
</div>
