<?php

use common\models\Sponsor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\search\SponsorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('backend', 'Sponsors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sponsor-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
    <?= Html::a(Yii::t('backend', 'Create Sponsor'), ['create'], ['class' => 'btn btn-success']) ?>
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
        'label' => Yii::t("backend",  'Image'),
        'value' => function ($model) {
          return Html::img('/' . $model->image_path, ['class' => 'img-fluid', 'width' => 400]);
        },
        'format' => 'raw',
      ],
      'name',
      'created_at',
      'updated_at',
      [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, Sponsor $model, $key, $index, $column) {
          return Url::toRoute([$action, 'id' => $model->id]);
        }
      ],
    ],
  ]); ?>

  <?php Pjax::end(); ?>

</div>
