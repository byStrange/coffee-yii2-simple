<?php

use common\models\Blog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\search\BlogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('backend', 'Blogs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(Yii::t('backend', 'Create Blog'), ['create'], ['class' => 'btn btn-success']) ?>
  </p>

  <?php Pjax::begin(); ?>
  <?php // echo $this->render('_search', ['model' => $searchModel]); 
  ?>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      'id',
      [
        'label' => Yii::t("backend",  'Title'),
        'value' => function ($model) {
          return Html::a($model->titleTextSource, ['blog/view', 'id' => $model->id]);
        },
        'format' => 'raw'
      ],

      [
        'label' => Yii::t("backend",  'Author'),
        'value' => function ($model) {
          return Html::a($model->author->username, ['user/view', 'id' => $model->author_id]);
        },
        'format' => 'raw',
      ],
      [
        'label' => Yii::t("backend",  'Thumbnail Image'),
        'value' => function ($model) {
          return Html::img('/' . $model->thumbnail_image, ['class' => 'img-fluid', 'width' => 400]);
        },
        'format' => 'raw',
      ],
      [
        'label' => Yii::t("backend",  'Main Image'),
        'value' => function ($model) {
          return Html::img('/' . $model->main_image, ['class' => 'img-fluid', 'width' => 400]);
        },
        'format' => 'raw',
      ],

      //'body:ntext',
      //'slug',
      //'views',
      //'status',
      //'created_at',
      //'updated_at',
      [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, Blog $model, $key, $index, $column) {
          return Url::toRoute([$action, 'id' => $model->id]);
        }
      ],
    ],
  ]); ?>

  <?php Pjax::end(); ?>

</div>
