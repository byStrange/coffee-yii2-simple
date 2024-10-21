<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\SiteInfo $model */

?>
<div class="site-info-view">
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
      'phone_number',
      'email:email',
      'address',
      'secondary_address',
      'start_week',
      'end_week',
      'start_time',
      'end_time',
      'facebook_url:url',
      'instagram_url:url',
      'telegram_url:url',
      'created_at',
      'updated_at',
    ],
  ]) ?>

</div>
