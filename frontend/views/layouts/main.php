<?php

/** @var \yii\web\View $this */

/** @var string $content */


use common\widgets\Alert;
use frontend\assets\AppAsset;

use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register( $this );

Yii::$app->language = Yii::$app->request->getPreferredLanguage( [
                                                                    'en-US',
                                                                    'de-DE',
                                                                ] );
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode( $this->title ) ?></title>
        <?php $this->head() ?>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link rel="icon" type="image/png" href="/img/favicon-96x96.png" sizes="96x96"/>
        <link rel="icon" type="image/svg+xml" href="/img/favicon.svg"/>
        <link rel="shortcut icon" href="/img/favicon.ico"/>
        <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png"/>
        <meta name="apple-mobile-web-app-title" content="BaitCalc"/>
        <link rel="manifest" href="/img/site.webmanifest"/>

    </head>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin( [
                           'brandLabel' => Html::img( '@web/img/logo.png', [
                                   'alt'   => Yii::$app->name,
                                   'style' => 'height: 30px;',
                               ] ) . ' ' . Yii::$app->name,
                           'brandUrl'   => Yii::$app->homeUrl,
                           'options'    => [
                               'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
                           ],
                       ] );
        $menuItems = [
            [
                'label' => 'Home',
                'url'   => ['/site/index'],
            ],
        ];
        if( Yii::$app->user->isGuest )
        {
            $menuItems[] = [
                'label' => Yii::t( 'common', 'Signup' ),
                'url'   => ['/site/signup'],
            ];
        }
        if( !Yii::$app->user->isGuest )
        {
            $menuItems[] = [
                'label' => Yii::t( 'common', 'Ingredients' ),
                'url'   => ['/ingredient/index'],
            ];
        }

        echo Nav::widget( [
                              'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
                              'items'   => $menuItems,
                          ] );
        if( Yii::$app->user->isGuest )
        {
            echo Html::tag( 'div', Html::a( 'Login', ['/site/login'], ['class' => ['btn btn-link login text-decoration-none']] ), ['class' => ['d-flex']] );
        }
        else
        {
            echo Html::beginForm( ['/site/logout'], 'post', ['class' => 'd-flex'] ) . Html::submitButton( 'Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout text-decoration-none'] ) . Html::endForm();
        }
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget( [
                                         'links' => $this->params['breadcrumbs'] ?? [],
                                     ] ); ?>
            <?= Alert::widget(); ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-start"><?= Html::encode( Yii::$app->name ) ?> &copy; 2024 - <?= date( 'Y' ) ?></p>
            <p class="float-end">Version <?= Yii::$app->params['version'] ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
