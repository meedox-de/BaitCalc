<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var LoginForm $model */

use common\models\LoginForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title                   = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode( $this->title ) ?></h1>

    <p><?= Yii::t( 'common', 'Please fill out the following fields to login:' ); ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin( ['id' => 'login-form'] ); ?>

            <?= $form->field( $model, 'username' )->textInput( ['autofocus' => true] ) ?>

            <?= $form->field( $model, 'password' )->passwordInput() ?>

            <?= $form->field( $model, 'rememberMe' )->checkbox() ?>

            <div class="my-1 mx-0" style="color:#999;">
                <?= Yii::t( 'common', 'If you forgot your password you can ' ) . Html::a( Yii::t( 'common', 'reset it' ), ['site/request-password-reset'] ) . '.' ?>

                <br>
                <?= Yii::t( 'common', 'Need new verification email?' ); ?> <?= Html::a( Yii::t( 'common', 'Resend' ), ['site/resend-verification-email'] ) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton( Yii::t( 'common', 'Login' ), [
                    'class' => 'btn btn-primary mt-3',
                    'name'  => 'login-button',
                ] ) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
