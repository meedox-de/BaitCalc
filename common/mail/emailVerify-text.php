<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl( [
                                                            'site/verify-email',
                                                            'token' => $user->verification_token,
                                                        ] );
?>
<?= Yii::t( 'common', 'Hello {user},', ['user' => $user->username] ) ?>

<?= Yii::t( 'common', 'Follow the link below to verify your email:' ) ?>

<?= $verifyLink ?>
