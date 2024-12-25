<?php

/** @var yii\web\View $this */

$this->title = 'BaitCalc - Home';

// require version_info file
require_once(Yii::getAlias( '@frontend/config/version_info.php' ));

/* @var $versionInfo array */
?>
<div class="site-index">
    <div class="bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <?php if( Yii::$app->user->isGuest ): ?>
                <h1 class="display-4"><?= Yii::t( 'common', 'Welcome to BaitCalc' ) ?></h1>
                <p class="fs-5 fw-light"><?= Yii::t( 'common', 'Please login or signup to use the application.' ) ?></p>
            <?php else: ?>
                <h1 class="display-4"><?= Yii::t( 'common', 'Welcome back, {user}', ['user' => Yii::$app->user->identity->username] ) ?></h1>
                <p class="fs-5 fw-light"><?= Yii::t( 'common', 'You are now logged in.' ) ?></p>
            <?php endif; ?>

            <p class="fs-5 fw-light"></p>
        </div>
    </div>

    <div class="body-content">

        <div class="container">
            <div class="row">

                <div class="col-12 col-md-6">
                    <h5><?= Yii::t('common', 'Hey,'); ?></h5>

                    <p><?= Yii::t('common', 'great to have you here! BaitCalc is here to help you manage your bait recipes quickly and easily.'); ?></p>
                    <p><?= Yii::t('common', 'If you have any questions or something doesn’t work as expected, just drop me an email at <strong>{email}</strong>. I’ll be happy to help!', ['email' => Yii::$app->params['adminEmail']]); ?></p>
                    <p><?= Yii::t('common', 'Have fun and good luck with the app!'); ?></p>

                    <?php if( Yii::$app->user->isGuest ): ?>
                        <p><a class="btn btn-outline-secondary" href="/site/signup"><?= Yii::t('common', 'Signup'); ?></a></p>
                    <?php endif; ?>
                </div>

                <div class="col-12 col-md-1 m-5 m-md-0"></div>

                <div class="col-12 col-md-5">
                    <h3>Versionsinfo</h3>

                    <?php foreach( $versionInfo as $version => $values ): ?>
                        <?php
                        // skip future versions
                        if( version_compare( $version, Yii::$app->params['version'], '>' ) )
                        {
                            continue;
                        }
                        ?>

                        <hr>
                        <div class="row mt-4">
                            <h5>Version <?= $version . ($version === Yii::$app->params['version'] ? ' (verwendet)' : ''); ?></h5>

                            <?php foreach( $values['changes'] as $change ): ?>
                                <p>- <?= $change; ?></p>
                            <?php endforeach; ?>

                            <p class="text-muted"><?= $values['date']; ?></p>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>

    </div>
</div>
