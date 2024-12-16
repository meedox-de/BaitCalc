<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var SignupForm $model */

use frontend\models\SignupForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title                   = Yii::t( 'common', 'Signup' );
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode( $this->title ) ?></h1>

    <p><?= Yii::t( 'common', 'Please fill out the following fields to signup:' ); ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin( ['id' => 'form-signup'] ); ?>

            <?= $form->field( $model, 'username' )->textInput( ['autofocus' => true] ) ?>

            <?= $form->field( $model, 'email' ) ?>

            <?= $form->field( $model, 'password' )->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton( Yii::t( 'common', 'Signup' ), [
                    'class' => 'btn btn-primary',
                    'name'  => 'signup-button',
                ] ) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
