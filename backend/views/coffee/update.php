<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Coffee $model */

$this->title = Yii::t('backend', 'Update Coffee: {name}', [
    'name' => $model,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Coffees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="coffee-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
