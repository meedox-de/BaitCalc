<?php

use common\models\Recipe;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\RecipeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title                   = Yii::t( 'common', 'Recipes' );
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register( $this );

$filterHtml = '<label class="mobile-label" for="filter-name">' . Recipe::instance()->getAttributeLabel( 'name' ) . '</label>' . '<div class="input-group">' . '<button class="btn btn-outline-secondary search-input" type="button" id="search-name">' . '<i class="bi bi-search"></i>' . '</button>' .
              Html::textInput( 'RecipeSearch[name]', $searchModel->name, [
                  'class'       => 'form-control',
                  'id'          => 'filter-name',
                  'placeholder' => Yii::t( 'common', 'Search name...' ),
              ] ) . '<button class="btn btn-outline-secondary clear-input" type="button" id="clear-name" style="display:none;">' . '<i class="bi bi-x"></i>' . '</button>' . '</div>';
?>
<div class="recipe-index">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
        <?= Html::a( '<i class="bi bi-plus-square-dotted"></i> ' . Yii::t( 'common', 'Create Recipe' ), ['create'], ['class' => 'btn btn-success'] ) ?>
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
                                      'filter'         => $filterHtml,
                                      'contentOptions' => ['data-label' => Recipe::instance()->getAttributeLabel( 'name' )],
                                  ],
                                  [
                                      'attribute'      => 'description',
                                      'value'          => function($model) {
                                          return StringHelper::truncate( $model->note, 20, '...' );
                                      },
                                      'contentOptions' => ['data-label' => Recipe::instance()->getAttributeLabel( 'description' )],
                                  ],
                                  [
                                      'attribute'      => 'note',
                                      'value'          => function($model) {
                                          return StringHelper::truncate( $model->note, 20, '...' );
                                      },
                                      'contentOptions' => ['data-label' => Recipe::instance()->getAttributeLabel( 'note' )],
                                  ],
                                  [
                                      'attribute'      => 'created_at',
                                      'format'         => [
                                          'date',
                                          'php:d.m.Y H:i',
                                      ],
                                      'contentOptions' => ['data-label' => Yii::t( 'common', 'Created At' )],
                                  ],
                                  [
                                      'class'    => ActionColumn::class,
                                      'template' => '{view} {update} {delete}',
                                      'buttons'  => [
                                          'view'   => function($url, $model, $key) {
                                              return Html::a( '<span class="badge bg-secondary"><i class="bi bi-eye"></i> ' . Yii::t( 'common', 'View' ) . '</span>', $url, [
                                                  'title'     => 'View',
                                                  'data-pjax' => '0',
                                              ] );
                                          },
                                          'update' => function($url, $model, $key) {
                                              return Html::a( '<span class="badge bg-primary"><i class="bi bi-pencil"></i> ' . Yii::t( 'common', 'Update' ) . '</span>', $url, [
                                                  'title'     => 'Edit',
                                                  'data-pjax' => '0',
                                              ] );
                                          },
                                          'delete' => function($url, $model, $key) {
                                              return Html::a( '<span class="badge bg-danger"><i class="bi bi-trash"></i> ' . Yii::t( 'common', 'Delete' ) . '</span>', $url, [
                                                  'title'        => 'Delete',
                                                  'data-confirm' => Yii::t( 'common', 'Are you sure you want to delete this item?' ),
                                                  'data-method'  => 'post',
                                              ] );
                                          },
                                      ],
                                  ],
                              ],
                          ] ); ?>

    <?php Pjax::end(); ?>

</div>
