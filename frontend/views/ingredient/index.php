<?php

use common\models\Category;
use common\models\Ingredient;
use common\models\IngredientSearch;
use frontend\assets\AppAsset;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var IngredientSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title                   = Yii::t( 'common', 'Ingredients' );
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register( $this );

$filterHtmlName = '<label class="mobile-label" for="filter-name">' . Yii::t( 'common', 'Search for name' ) . '</label>' . '<div class="input-group">' . '<button class="btn btn-outline-secondary search-input" type="button" id="search-name">' . '<i class="bi bi-search"></i>' . '</button>' .
                  Html::textInput( 'IngredientSearch[name]', $searchModel->name, [
                      'class'       => 'form-control',
                      'id'          => 'filter-name',
                      'placeholder' => Yii::t( 'common', 'Search name...' ),
                  ] ) . '<button class="btn btn-outline-secondary clear-input" type="button" id="clear-name" style="display:none;">' . '<i class="bi bi-x"></i>' . '</button>' . '</div>';

$filterHtmlCategory = '<label class="mobile-label" for="filter-name">' . Yii::t( 'common', 'Search for category' ) . '</label>' . Html::activeDropDownList( $searchModel, 'category_id', Category::getCategoryListForDropdown(), [
        'prompt' => Yii::t( 'common', 'All' ),
        'class'  => 'form-control',
    ] );

?>
<div class="ingredient-index">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
        <?= Html::a( '<i class="bi bi-plus-square-dotted"></i> ' . Yii::t( 'common', 'Create Ingredient' ), ['create'], ['class' => 'btn btn-success'] ) ?>
    </p>

    <?php Pjax::begin( ['id' => 'pjax-container'] ); ?>

    <?= GridView::widget( [
                              'dataProvider' => $dataProvider,
                              'filterModel'  => $searchModel,
                              'tableOptions' => ['class' => 'table table-striped table-bordered responsive-table'],
                              'columns'      => [
                                  ['class' => 'yii\grid\SerialColumn'],
                                  [
                                      'attribute'      => 'name',
                                      'filter'         => $filterHtmlName,
                                      'contentOptions' => ['data-label' => Ingredient::instance()->getAttributeLabel( 'name' )],
                                  ],
                                  [
                                      'attribute'      => 'category_id',
                                      'value'          => 'category.name',
                                      'label'          => Yii::t( 'common', 'Category' ),
                                      'contentOptions' => ['data-label' => Yii::t( 'common', 'Category' )],
                                      'filter'         => $filterHtmlCategory,
                                  ],
                                  [
                                      'attribute'      => 'protein',
                                      'contentOptions' => ['data-label' => Ingredient::instance()->getAttributeLabel( 'protein' )],
                                      'value'          => function($model) {
                                          return number_format( $model->protein, 2, ',', '.' ) . ' %';
                                      },
                                  ],
                                  [
                                      'attribute'      => 'fat',
                                      'contentOptions' => ['data-label' => Ingredient::instance()->getAttributeLabel( 'fat' )],
                                      'value'          => function($model) {
                                          return number_format( $model->fat, 2, ',', '.' ) . ' %';
                                      },
                                  ],
                                  [
                                      'attribute'      => 'carbohydrate',
                                      'contentOptions' => ['data-label' => Ingredient::instance()->getAttributeLabel( 'carbohydrate' )],
                                      'value'          => function($model) {
                                          return number_format( $model->carbohydrate, 2, ',', '.' ) . ' %';
                                      },
                                  ],
                                  [
                                      'attribute'      => 'note',
                                      'value'          => function($model) {
                                          if( empty( $model->note ) )
                                          {
                                              return '<span style="color: #c55;"><i>(nicht gesetzt)</i></span>';
                                          }
                                          return StringHelper::truncate( $model->note, 20, '...' );
                                      },
                                      'format'         => 'raw',
                                      'contentOptions' => ['data-label' => Ingredient::instance()->getAttributeLabel( 'note' )],
                                  ],
                                  [
                                      'attribute'      => 'created_at',
                                      'format'         => [
                                          'date',
                                          'php:d.m.Y H:i',
                                      ],
                                      'contentOptions' => ['data-label' => Ingredient::instance()->getAttributeLabel( 'created_at' )],
                                  ],
                                  [
                                      'class'    => ActionColumn::class,
                                      'template' => '{update} {delete}',
                                      'buttons'  => [
                                          'update' => function($url, $model, $key) {
                                              return Html::a( '<span class="badge bg-primary"><i class="bi bi-pencil"></i> ' . Yii::t( 'common', 'Update' ) . '</span>', $url, [
                                                  'title'     => 'Edit',
                                                  'data-pjax' => '0',
                                              ] );
                                          },
                                          'delete' => function($url, $model, $key) {
                                              return Html::a( '<span class="badge bg-danger"><i class="bi bi-trash"></i> ' . Yii::t( 'common', 'Delete' ) . '</span>', $url, [
                                                  'title'        => 'Delete',
                                                  'data-confirm' => Yii::t( 'common', 'Attention! Do you really want to delete the ingredient? This ingredient will then be removed from all recipes and the recipes will be changed!' ),
                                                  'data-method'  => 'post',
                                              ] );
                                          },
                                      ],
                                  ],
                              ],
                          ] ); ?>

    <?php Pjax::end(); ?>

</div>
