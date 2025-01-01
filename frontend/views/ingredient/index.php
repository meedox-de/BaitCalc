<?php

use common\models\IngredientSearch;
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

?>
<div class="ingredient-index">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
        <?= Html::a( '<i class="bi bi-plus-square-dotted"></i> ' . Yii::t( 'common', 'Create Ingredient' ), ['create'], ['class' => 'btn btn-success'] ) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget( [
                              'dataProvider' => $dataProvider,
                              'filterModel'  => $searchModel,
                              'columns'      => [
                                  ['class' => 'yii\grid\SerialColumn'],
                                  'name',
                                  [
                                      'attribute' => 'category_id',
                                      'value'     => 'category.name',
                                      'label'     => Yii::t( 'common', 'Category' ),
                                  ],
                                  'protein',
                                  'fat',
                                  'carbohydrate',
                                  [
                                      'attribute' => 'note',
                                      'value'     => function($model) {
                                          return StringHelper::truncate( $model->note, 20, '...' );
                                      },
                                  ],
                                  [
                                      'attribute' => 'created_at',
                                      'format'    => [
                                          'date',
                                          'php:d.m.Y H:i',
                                      ],
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
