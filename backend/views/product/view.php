<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Product $model */

$this->title = $model;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(Yii::t('backend', 'Update'), ['update'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('backend', 'Delete'), ['delete'], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
        'method' => 'post',
      ],
    ]) ?>
  </p>

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      'id',
      ['label' => Yii::t("backend",  'Title'), 'value' => $model->titleTextSource],
      ['label' => Yii::t("backend",  'Description'), 'value' => $model->descriptionTextSource],
      [
        "label" => Yii::t('backend', 'Image layer 1'),
        "value" => Html::img('/' . $model->image_layer_1, ['class' => 'img-fluid', 'width' => 400]),
        'format' => 'raw',
      ],
      [
        "label" => Yii::t('backend', 'Image layer 2'),
        "value" => Html::img('/' . $model->image_layer_2, ['class' => 'img-fluid', 'width' => 400]),
        'format' => 'raw',
      ],
      'price',
      'created_at',
      'updated_at',
    ],
  ]) ?>

</div>
