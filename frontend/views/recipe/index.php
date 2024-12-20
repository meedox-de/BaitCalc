<?php

use common\models\Recipe;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\RecipeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title                   = Yii::t( 'common', 'Recipes' );
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-index">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
        <?= Html::a( Yii::t( 'common', 'Create Recipe' ), ['create'], ['class' => 'btn btn-success'] ) ?>
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
                                      'attribute' => 'description',
                                      'value'     => function($model) {
                                          return StringHelper::truncate( $model->note, 20, '...' );
                                      },
                                  ],
                                  [
                                      'attribute' => 'note',
                                      'value'     => function($model) {
                                          return StringHelper::truncate( $model->note, 20, '...' );
                                      },
                                  ],
                                  [
                                      'attribute' => 'created_at',
                                      'format'    => ['date', 'php:d.m.Y H:i'],
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
                                                                                                                                                                         'data-confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                                                                                                                                                                         'data-method'  => 'post',
                                                                                                                                                                     ] );
                                          },
                                      ],
                                  ],
                              ],
                          ] ); ?>

    <?php Pjax::end(); ?>

</div>
