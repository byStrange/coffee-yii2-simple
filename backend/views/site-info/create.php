<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SiteInfo $model */

$this->title = Yii::t('backend', 'Create Site Info');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Site Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
