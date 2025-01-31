<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Coffee $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Coffees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="coffee-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
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
      'price',
      'text_source_id',
      [
        'label' => Yii::t("backend",  'Image'),
        'value' => Html::img('/' . $model->image, ['class' => 'img-fluid', 'width' => 400]),
        'format' => 'raw',
      ],
      'description_text_source_id',
      'created_at',
      'updated_at',
    ],
  ]) ?>

</div>
