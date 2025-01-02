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
    $categoryId = $ingredient['category_id'] ?? 0;
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
    <ul>
        <li><?= Yii::t( 'common', 'Protein:' ) ?> <span id="total-protein">0</span> %</li>
        <li><?= Yii::t( 'common', 'Fat:' ) ?> <span id="total-fat">0</span> %</li>
        <li><?= Yii::t( 'common', 'Carbohydrates:' ) ?> <span id="total-carbohydrates">0</span> %</li>
    </ul>

    <h4>Zutaten</h4>
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
                                <div class="ingredient-item mb-2">
                                    <div class="d-flex align-items-center">
                                        <input type="number"
                                               class="form-control ingredient-input me-2"
                                               id="ingredient-<?= $ingredient['id'] ?>"
                                               name="ingredients[<?= $ingredient['id'] ?>]"
                                               value="<?= number_format( $savedIngredients[$ingredient['id']] ?? 0, 2, '.', '' ) ?>"
                                               min="0"
                                               step="1.0"
                                               max="100"
                                               data-fat="<?= $ingredient['fat'] ?>"
                                               data-protein="<?= $ingredient['protein'] ?>"
                                               data-carbohydrates="<?= $ingredient['carbohydrate'] ?>"
                                               style="width: 90px;">
                                        <span class="flex-grow-1"><?= Html::encode( $ingredient['name'] ) ?></span>
                                    </div>
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
