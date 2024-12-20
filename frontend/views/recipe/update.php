<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Recipe $model */

$this->title = Yii::t('common', 'Update Recipe: "{name}"', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Recipes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="recipe-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
