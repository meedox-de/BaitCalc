<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public      $username;
    public      $password;
    public bool $rememberMe = true;

    private ?User $_user = null;


    /**
     * {@inheritdoc}
     */
    public function rules() :array
    {
        return [
            // username and password are both required
            [
                [
                    'username',
                    'password',
                ],
                'required',
            ],
            // rememberMe must be a boolean value
            [
                'rememberMe',
                'boolean',
            ],
            // password is validated by validatePassword()
            [
                'password',
                'validatePassword',
            ],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array  $params    the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute, ?array $params) :void
    {
        if( !$this->hasErrors() )
        {
            $user = $this->getUser();
            if( !$user || !$user->validatePassword( $this->password ) )
            {
                $this->addError( $attribute, 'Incorrect username or password.' );
            }
        }
    }

    /**
     * @return array
     */
    public function attributeLabels() :array
    {
        return [
            'username'   => Yii::t( 'common', 'Email' ),
            'password'   => Yii::t( 'common', 'Password' ),
            'rememberMe' => Yii::t( 'common', 'Remember Me' ),
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login() :bool
    {
        if( $this->validate() )
        {
            return Yii::$app->user->login( $this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0 );
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser() :?User
    {
        if( is_null( $this->_user ) )
        {
            $this->_user = User::findByUsername( $this->username );
        }

        return $this->_user;
    }
}
