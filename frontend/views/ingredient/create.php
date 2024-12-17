<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Ingredient $model */

$this->title = Yii::t('common', 'Create Ingredient');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Ingredients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
