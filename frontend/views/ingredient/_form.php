<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Ingredient $model */
/** @var ActiveForm $form */

?>

<div class="ingredient-form">

    <?php $form = ActiveForm::begin(['layout' => ActiveForm::LAYOUT_HORIZONTAL]); ?>

    <?= $form->field( $model, 'name' )->textInput( ['maxlength' => true] ) ?>

    <?= $form->field( $model, 'protein' )->textInput( ['maxlength' => true] ) ?>

    <?= $form->field( $model, 'fat' )->textInput( ['maxlength' => true] ) ?>

    <?= $form->field( $model, 'carbohydrate' )->textInput( ['maxlength' => true] ) ?>

    <?= $form->field( $model, 'note' )->textarea( ['rows' => 6] ) ?>

    <div class="form-group">
        <?= Html::submitButton( Yii::t( 'common', 'Save' ), ['class' => 'btn btn-success'] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
