<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TextTranslation $model */

$this->title = Yii::t('backend', 'Create Text Translation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Text Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-translation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
