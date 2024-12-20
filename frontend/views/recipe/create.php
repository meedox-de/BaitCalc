<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Recipe $model */

$this->title = Yii::t('common', 'Create Recipe');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Recipes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
