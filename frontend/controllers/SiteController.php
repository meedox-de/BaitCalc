<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() :array
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() :array
    {
        return [
            'error'   => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class'           => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() :mixed
    {

        return $this->render( 'index' );
    }

    /**
     * Logs in a user.
     *
     * @return string|Response
     */
    public function actionLogin() :string|Response
    {
        if( !Yii::$app->user->isGuest )
        {
            return $this->goHome();
        }

        $model = new LoginForm();
        if( $model->load( Yii::$app->request->post() ) && $model->login() )
        {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render( 'login', [
            'model' => $model,
        ] );
    }

    /**
     * Logs out the current user.
     *
     * @return Response
     */
    public function actionLogout() :Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() :string
    {
        return $this->render( 'about' );
    }

    /**
     * Signs user up.
     *
     * @return string|Response
     * @throws Exception
     */
    public function actionSignup() :string|Response
    {
        $model = new SignupForm();
        if( $model->load( Yii::$app->request->post() ) && $model->signup() )
        {
            Yii::$app->session->setFlash( 'success', Yii::t( 'common', 'Thank you for registration. Please check your inbox for verification email.' ) );
            return $this->goHome();
        }

        return $this->render( 'signup', [
            'model' => $model,
        ] );
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() :mixed
    {
        $model = new PasswordResetRequestForm();
        if( $model->load( Yii::$app->request->post() ) && $model->validate() )
        {
            if( $model->sendEmail() )
            {
                Yii::$app->session->setFlash( 'success', 'Check your email for further instructions.' );

                return $this->goHome();
            }

            Yii::$app->session->setFlash( 'error', 'Sorry, we are unable to reset password for the provided email address.' );
        }

        return $this->render( 'requestPasswordResetToken', [
            'model' => $model,
        ] );
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword(string $token) :mixed
    {
        try
        {
            $model = new ResetPasswordForm( $token );
        }
        catch( InvalidArgumentException $e )
        {
            throw new BadRequestHttpException( $e->getMessage() );
        }

        if( $model->load( Yii::$app->request->post() ) && $model->validate() && $model->resetPassword() )
        {
            Yii::$app->session->setFlash( 'success', 'New password saved.' );

            return $this->goHome();
        }

        return $this->render( 'resetPassword', [
            'model' => $model,
        ] );
    }

    /**
     * Verify email address
     *
     * @param string $token
     *
     * @return Response
     */
    public function actionVerifyEmail(string $token) :Response
    {
        try
        {
            $model = new VerifyEmailForm( $token );
            $user  = $model->verifyEmail();

            if( $user && Yii::$app->user->login( $user ) )
            {
                Yii::$app->session->setFlash( 'success', Yii::t( 'common', 'Your email has been confirmed!' ) );
                return $this->goHome();
            }

            Yii::$app->session->setFlash( 'error', Yii::t( 'common', 'Unable to verify your account with the provided token.' ) );
        }
        catch( InvalidArgumentException $e )
        {
            Yii::$app->session->setFlash( 'error', $e->getMessage() );
        }
        catch( Exception $e )
        {
            Yii::error( $e->getMessage(), __METHOD__ );
            Yii::$app->session->setFlash( 'error', Yii::t( 'common', 'An unexpected error occurred. Please try again later.' ) );
        }

        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail() :mixed
    {
        $model = new ResendVerificationEmailForm();
        if( $model->load( Yii::$app->request->post() ) && $model->validate() )
        {
            if( $model->sendEmail() )
            {
                Yii::$app->session->setFlash( 'success', 'Check your email for further instructions.' );
                return $this->goHome();
            }
            Yii::$app->session->setFlash( 'error', 'Sorry, we are unable to resend verification email for the provided email address.' );
        }

        return $this->render( 'resendVerificationEmail', [
            'model' => $model,
        ] );
    }
}
