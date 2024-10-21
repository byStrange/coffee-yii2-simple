<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\search\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('backend', 'Main product');
?>
<div class="product-index">

  <h1><?= Html::encode($this->title) ?></h1>


  <?php if (!$product): ?>
    <p>
      <?= Html::a(Yii::t('backend', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  <?php else: ?>
    <?= $this->render('view', ['model' => $product]) ?>
  <?php endif ?>


</div>
