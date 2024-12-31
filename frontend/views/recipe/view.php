<?php

use common\models\Ingredient;
use common\models\RecipeIngredient;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Recipe $model */
/** @var Ingredient $ingredients */
/** @var RecipeIngredient[] $recipeIngredients */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t( 'common', 'Recipes' ),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register( $this );

$this->registerJsFile( '@web/js/recipe.js', ['depends' => [\yii\web\JqueryAsset::class]] );

// $ingredients is an array of Ingredient objects
$savedIngredients = [];
foreach( $recipeIngredients as $recipeIngredient )
{
    $savedIngredients[$recipeIngredient->ingredient_id] = $recipeIngredient->quantity;
}
?>
<div class="recipe-view">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
        <?= Html::a( Yii::t( 'common', 'Back to Recipes' ), ['index'], ['class' => 'btn btn-secondary'] ) ?>
        <?= Html::a( Yii::t( 'common', 'Update' ), [
            'update',
            'id' => $model->id,
        ],           ['class' => 'btn btn-primary'] ) ?>
        <?= Html::a( Yii::t( 'common', 'Delete' ), [
            'delete',
            'id' => $model->id,
        ],           [
                         'class' => 'btn btn-danger',
                         'data'  => [
                             'confirm' => Yii::t( 'common', 'Are you sure you want to delete this item?' ),
                             'method'  => 'post',
                         ],
                     ] ) ?>
    </p>

    <?= DetailView::widget( [
                                'model'      => $model,
                                'attributes' => [
                                    'name',
                                    'description:ntext',
                                    'note:ntext',
                                    [
                                        'attribute' => 'created_at',
                                        'format'    => [
                                            'date',
                                            'php:d.m.Y H:i',
                                        ],
                                    ],
                                    [
                                        'attribute' => 'updated_at',
                                        'format'    => [
                                            'date',
                                            'php:d.m.Y H:i',
                                        ],
                                    ],
                                ],
                            ] ) ?>

    <?= Html::beginForm( [
                             'recipe/view',
                             'id' => $model->id,
                         ], 'post', ['id' => 'save-ingredients-form'] ) ?>
    <div>
        <?= Html::submitButton( Yii::t( 'common', 'Save' ), ['class' => 'btn btn-success'] ) ?>
    </div>

    <h4><?= Yii::t( 'common', 'Totals' ) ?></h4>
    <ul>
        <li><?= Yii::t( 'common', 'Fat:' ) ?> <span id="total-fat">0</span> %</li>
        <li><?= Yii::t( 'common', 'Protein:' ) ?> <span id="total-protein">0</span> %</li>
        <li><?= Yii::t( 'common', 'Carbohydrates:' ) ?> <span id="total-carbohydrates">0</span> %</li>
    </ul>

    <h3>Zutaten</h3>
    <div id="ingredient-list">
        <?php foreach( $ingredients as $ingredient ): ?>
            <div class="ingredient-item">
                <input type="number"
                       class="ingredient-input"
                       id="ingredient-<?= $ingredient['id'] ?>"
                       value="<?= number_format($savedIngredients[$ingredient['id']] ?? 0, 2, '.', '') ?>"
                       min="0"
                       max="100"
                       step="1.00"
                       data-fat="<?= $ingredient['fat'] ?>"
                       data-protein="<?= $ingredient['protein'] ?>"
                       data-carbohydrates="<?= $ingredient['carbohydrate'] ?>">
                <span><?= Html::encode( $ingredient['name'] ) ?></span>
            </div>
        <?php endforeach; ?>
    </div>

    <?= Html::endForm() ?>
</div>
