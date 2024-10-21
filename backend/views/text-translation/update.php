<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TextTranslation $model */

$this->title = Yii::t('backend', 'Update Text Translation: {name}', [
  'name' => $model->id,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Text Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="text-translation-update">

  <h1><?= Html::encode($this->title) ?></h1>

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>
