<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\db\Exception;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules() :array
    {
        return [
            [
                'username',
                'trim',
            ],
            [
                'username',
                'required',
            ],
            [
                'username',
                'unique',
                'targetClass' => '\common\models\User',
                'message'     => 'This username has already been taken.',
            ],
            [
                'username',
                'string',
                'min' => 2,
                'max' => 255,
            ],

            [
                'email',
                'trim',
            ],
            [
                'email',
                'required',
            ],
            [
                'email',
                'email',
            ],
            [
                'email',
                'string',
                'max' => 255,
            ],
            [
                'email',
                'unique',
                'targetClass' => '\common\models\User',
                'message'     => 'This email address has already been taken.',
            ],

            [
                'password',
                'required',
            ],
            [
                'password',
                'string',
                'min' => Yii::$app->params['user.passwordMinLength'],
            ],
        ];
    }

    public function attributeLabels() :array
    {
        return [
            'username' => Yii::t( 'common', 'Username' ),
            'email'    => Yii::t( 'common', 'Email' ),
            'password' => Yii::t( 'common', 'Password' ),
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws Exception
     */
    public function signup() :?bool
    {
        if( !$this->validate() )
        {
            return null;
        }

        $user           = new User();
        $user->username = $this->username;
        $user->email    = $this->email;
        $user->setPassword( $this->password );
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        return $user->save() && $this->sendEmail( $user );
    }

    /**
     * Sends confirmation email to user
     *
     * @param User $user user model to with email should be send
     *
     * @return bool whether the email was sent
     */
    protected function sendEmail(User $user) :bool
    {
        return Yii::$app->mailer->compose( [
                                               'html' => 'emailVerify-html',
                                               'text' => 'emailVerify-text',
                                           ], ['user' => $user] )->setFrom( [Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'] )->setTo( $this->email )->setSubject( 'Account registration at ' . Yii::$app->name )->send();
    }
}
