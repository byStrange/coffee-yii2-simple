<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Sponsor $model */

$this->title = Yii::t('backend', 'Create Sponsor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Sponsors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sponsor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
