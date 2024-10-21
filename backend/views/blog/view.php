<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Blog $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="blog-view">

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
      ['label' => Yii::t("backend",  'Title'), 'value' => $model->titleTextSource],
      'author_id',
      [
        'label' => Yii::t("backend",  'Thumbnail Image'),
        'value' => Html::img('/' . $model->thumbnail_image, ['class' => 'img-fluid', 'width' => 400]),
        'format' => 'raw',
      ],
      [
        'label' => Yii::t("backend",  'Main Image'),
        'value' => Html::img('/' . $model->main_image, ['class' => 'img-fluid', 'width' => 400]),
        'format' => 'raw',
      ],
      [
        "label" => Yii::t('backend', 'Highlighted text'),
        'value' => $model->highlightedTextSource,
      ],
      'body:ntext',
      'slug',
      'views',
      'status',
      'created_at',
      'updated_at',
    ],
  ]) ?>

</div>
