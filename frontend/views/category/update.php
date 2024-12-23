<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Category $model */

$this->title = Yii::t( 'common', 'Update Category: {name}', [
    'name' => $model->name,
] );
$this->params['breadcrumbs'][] = [
    'label' => Yii::t( 'common', 'Categories' ),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-update">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
