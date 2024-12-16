<?php

/** @var yii\web\View $this */

$this->title = 'BaitCalc - Home';
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <?php if( Yii::$app->user->isGuest ): ?>
                <h1 class="display-4"><?= Yii::t('common', 'Welcome to BaitCalc') ?></h1>
                <p class="fs-5 fw-light"><?= Yii::t('common', 'Please login or signup to use the application.') ?></p>
            <?php else: ?>
                <h1 class="display-4"><?= Yii::t('common', 'Welcome back, {user}', ['user' => Yii::$app->user->identity->username]) ?></h1>
                <p class="fs-5 fw-light"><?= Yii::t('common', 'You are now logged in.') ?></p>
            <?php endif; ?>

            <p class="fs-5 fw-light"></p>
        </div>
    </div>

    <div class="body-content">

        <div class="row">

            <div class="col-6">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="/">Test</a></p>
            </div>

            <div class="col-6">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="/">Test</a></p>
            </div>

        </div>

    </div>
</div>
