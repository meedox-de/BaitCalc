<?php

use common\models\Category;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title                   = Yii::t( 'common', 'Categories' );
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register( $this );

$filterHtml = '<label class="mobile-label" for="filter-name">' . Category::instance()->getAttributeLabel( 'name' ) . '</label>' . '<div class="input-group">' . '<button class="btn btn-outline-secondary search-input" type="button" id="search-name">' . '<i class="bi bi-search"></i>' . '</button>' .
              Html::textInput( 'CategorySearch[name]', $searchModel->name, [
                  'class'       => 'form-control',
                  'id'          => 'filter-name',
                  'placeholder' => Yii::t( 'common', 'Search name...' ),
              ] ) . '<button class="btn btn-outline-secondary clear-input" type="button" id="clear-name" style="display:none;">' . // X-Symbol standardmäßig ausblenden
              '<i class="bi bi-x"></i>' . '</button>' . '</div>';
?>

<div class="category-index">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
        <?= Html::a( Yii::t( 'common', 'Create Category' ), ['create'], ['class' => 'btn btn-success'] ) ?>
    </p>

    <?php Pjax::begin( ['id' => 'category-pjax-container'] ); ?>

    <?= GridView::widget( [
                              'dataProvider' => $dataProvider,
                              'filterModel'  => $searchModel,
                              'tableOptions' => ['class' => 'table table-striped table-bordered responsive-table'],
                              'columns'      => [
                                  ['class' => 'yii\grid\SerialColumn'],
                                  [
                                      'attribute'      => 'name',
                                      'filter'         => $filterHtml,
                                      'contentOptions' => ['data-label' => Category::instance()->getAttributeLabel( 'name' )],
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
                                                  'data-confirm' => Yii::t( 'common', 'Attention! Do you really want to delete the category? All ingredients that belonged to this category will then be uncategorized.' ),
                                                  'data-method'  => 'post',
                                              ] );
                                          },
                                      ],
                                  ],
                              ],
                          ] ); ?>

    <?php Pjax::end(); ?>

</div>