<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl( [
                                                            'site/verify-email',
                                                            'token' => $user->verification_token,
                                                        ] );
?>
<div class="verify-email">
    <p><?= Yii::t( 'common', 'Hello {user},', ['user' => Html::encode( $user->username )] ) ?></p>

    <p><?= Yii::t( 'common', 'Follow the link below to verify your email:' ) ?></p>

    <p><?= Html::a( Html::encode( $verifyLink ), $verifyLink ) ?></p>
</div>
