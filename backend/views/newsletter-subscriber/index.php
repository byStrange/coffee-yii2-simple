<?php

use common\models\NewsletterSubscriber;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\search\NewsletterSubscriberSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('backend', 'Newsletter Subscribers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsletter-subscriber-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <?php Pjax::begin(); ?>
  <?php // echo $this->render('_search', ['model' => $searchModel]); 
  ?>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      'id',
      'email:email',
      'created_at',
      'updated_at',
      [
        'class' => ActionColumn::className(),
        'template' => '{delete} {view}',
        'urlCreator' => function ($action, NewsletterSubscriber $model, $key, $index, $column) {
          return Url::toRoute([$action, 'id' => $model->id]);
        }
      ],
    ],
  ]); ?>

  <?php Pjax::end(); ?>

</div>
