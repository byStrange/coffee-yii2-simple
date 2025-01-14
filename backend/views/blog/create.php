<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Blog $model */

$this->title = Yii::t('backend', 'Create Blog');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
