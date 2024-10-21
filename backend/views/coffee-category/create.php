<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CoffeeCategory $model */

$this->title = Yii::t('backend', 'Create Coffee Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Coffee Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coffee-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
