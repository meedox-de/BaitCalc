<?php

use common\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title                   = Yii::t( 'common', 'Categories' );
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
        <?= Html::a( Yii::t( 'common', 'Create Category' ), ['create'], ['class' => 'btn btn-success'] ) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget( [
                              'dataProvider' => $dataProvider,
                              'filterModel'  => $searchModel,
                              'columns'      => [
                                  ['class' => 'yii\grid\SerialColumn'],
                                  'name',
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
