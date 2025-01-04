<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl( [
                                                           'site/reset-password',
                                                           'token' => $user->password_reset_token,
                                                       ] );
?>

<?= Yii::t( 'common', 'Hello {user},', ['user' => $user->username] ) ?>

<?= Yii::t( 'common', 'Follow the link below to reset your password:' ) ?>

<?= $resetLink ?>
