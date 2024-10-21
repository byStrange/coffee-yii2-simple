<?php

use common\models\SiteInfo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\SiteInfoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('backend', 'Site Info');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-info-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <?php if (!$model): ?>

    <p>
      <?= Html::a(Yii::t('backend', 'Create Site Info'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  <?php else: ?>
    <?= $this->render('view', ['model' => $model]) ?>
  <?php endif ?>

</div>
