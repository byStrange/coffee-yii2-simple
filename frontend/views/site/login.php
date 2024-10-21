<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
$this->registerAssetBundle('yii\bootstrap5\BootstrapAsset');

$this->registerAssetBundle('yii\jui\JuiAsset');

?>


<div class="container mt-3">
  <div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
      <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>


        <div class="form-group" style="display: flex; gap: 12px; align-items: center;">
          <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

          <?= Html::a('Register', ['/site/signup'], ['class' => 'btn-link']) ?>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>
</div>
</div>
