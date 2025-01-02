<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Ingredient $model */

$this->title                   = Yii::t( 'common', 'Update Ingredient: "{name}"', [
    'name' => $model->name,
] );
$this->params['breadcrumbs'][] = [
    'label' => Yii::t( 'common', 'Ingredients' ),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-update">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <div class="alert alert-warning" role="alert">
        <?= Yii::t( 'common', 'Attention! Changing the values of the ingredient will affect all recipes that contain this ingredient.' ) ?>
    </div>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
