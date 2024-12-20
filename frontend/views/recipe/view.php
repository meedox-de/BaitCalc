<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Recipe $model */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t( 'common', 'Recipes' ),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register( $this );
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
                                    'id',
                                    'user_id',
                                    'name',
                                    'description:ntext',
                                    'note:ntext',
                                    'created_at',
                                    'updated_at',
                                ],
                            ] ) ?>

</div>
