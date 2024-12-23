<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Category $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'name' )->textInput( ['maxlength' => true] ) ?>

    <div class="form-group">
        <?= Html::a( Yii::t( 'common', 'Cancel' ), ['index'], ['class' => 'btn btn-outline-danger'] ) ?>
        <?= Html::submitButton( Yii::t( 'common', 'Save' ), ['class' => 'btn btn-success'] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
