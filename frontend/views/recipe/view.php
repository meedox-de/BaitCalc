<?php

use common\models\Ingredient;
use common\models\RecipeIngredient;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Recipe $model */
/** @var array $categories */
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

// Group ingredients by category
$groupedIngredients = [];
foreach( $ingredients as $ingredient )
{
    $categoryId                        = $ingredient['category_id'] ?? 0;
    $groupedIngredients[$categoryId][] = $ingredient;
}

$accordionId = 0; // Unique ID for each collapsible section
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
        <?= Html::submitButton( Yii::t( 'common', 'Save recipe' ), ['class' => 'btn btn-success mt-5 mb-3'] ) ?>
    </div>

    <h4><?= Yii::t( 'common', 'Totals' ) ?></h4>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title"><?= Yii::t( 'common', 'Protein' ) ?></h5>
                    <p class="card-text"><span id="total-protein">0</span> %</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title"><?= Yii::t( 'common', 'Fat' ) ?></h5>
                    <p class="card-text"><span id="total-fat">0</span> %</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title"><?= Yii::t( 'common', 'Carbohydrates' ) ?></h5>
                    <p class="card-text"><span id="total-carbohydrates">0</span> %</p>
                </div>
            </div>
        </div>
    </div>

    <h4>Zutaten (<span id="total-percentage" class="fw-bold">0</span> %)</h4>
    <div id="ingredient-list" class="row">
        <?php foreach( $groupedIngredients as $categoryId => $categoryIngredientsArray ):
            $accordionId++;
            ?>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 w-100">
                            <button class="btn btn-link text-decoration-none w-100 text-start d-flex align-items-center justify-content-between text-dark"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse-<?= $accordionId ?>"
                                    aria-expanded="false"
                                    aria-controls="collapse-<?= $accordionId ?>">
                                <?= Html::encode( $categories[$categoryId] ?? Yii::t( 'common', 'Uncategorized' ) ) ?>
                                <span class="collapse-icon">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                            </button>
                        </h5>
                    </div>
                    <div id="collapse-<?= $accordionId ?>" class="collapse" aria-labelledby="heading-<?= $accordionId ?>">
                        <div class="card-body">
                            <?php foreach( $categoryIngredientsArray as $ingredient ): ?>
                                <div class="ingredient-item mb-2 d-flex align-items-center">
                                    <div class="input-group" style="flex: 1;">
                                        <span class="input-group-text">%</span>
                                        <input type="text"
                                               class="form-control ingredient-input"
                                               id="ingredient-<?= $ingredient['id'] ?>"
                                               name="ingredients[<?= $ingredient['id'] ?>]"
                                               value="<?= number_format( $savedIngredients[$ingredient['id']] ?? 0, 2, '.', '' ) ?>"
                                               maxlength="5"
                                               data-fat="<?= $ingredient['fat'] ?>"
                                               data-protein="<?= $ingredient['protein'] ?>"
                                               data-carbohydrates="<?= $ingredient['carbohydrate'] ?>"
                                        >
                                        <button class="btn btn-outline-secondary decrement" type="button" data-ingredient-id="<?= $ingredient['id'] ?>">-</button>
                                        <button class="btn btn-outline-secondary increment" type="button" data-ingredient-id="<?= $ingredient['id'] ?>">+</button>
                                    </div>
                                    <label for="ingredient-<?= $ingredient['id'] ?>" class="ms-2 flex-grow-1">
                                        <?= Html::encode( $ingredient['name'] ) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?= Html::endForm() ?>
</div>