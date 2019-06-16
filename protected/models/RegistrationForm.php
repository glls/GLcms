<?php

/**
 * This form handles and initiates the registration of new users on behalf of User
 */
class RegistrationForm extends CFormModel
{
    /**
     * @var string $email The email address of the user
     */
    public $email;

    /**
     * @var string $name The first name of the user
     */
    public $name;

    /**
     * @var string $password The users new password
     */
    public $password;

    /**
     * @var string $username The users username
     */
    public $username;

    /**
     * The user model
     * @var Users $_user
     */
    public $_user;

    /**
     * Validate rules
     */
    public function rules()
    {
        return [
            // Email is Required, and must be an email
            ['email, username, name, password', 'required'],
            ['password', 'length', 'min' => 8],
            ['email', 'email'],
            ['username', 'validateUsername'],
            ['email', 'verifyEmailIsUnique']
        ];
    }

    /**
     * Validates the username
     * @param array $attributes The attributes
     * @param array $params The params
     * @return boolean
     */
    public function validateUsername($attributes, $params)
    {
        $user = User::model()->findByAttributes(['username' => $this->username]);

        if ($user === null) {
            return true;
        } else {
            $this->addError('username', 'That username has already been registered');
            return false;
        }
    }

    /**
     * Validates the username
     * @param array $attributes The attributes
     * @param array $params The params
     * @return boolean
     */
    public function verifyEmailIsUnique($attributes, $params)
    {
        $user = User::model()->findByAttributes(['email' => $this->email]);

        if ($user === null) {
            return true;
        } else {
            $this->addError('email', 'That email address has already been registered');
            return false;
        }
    }

    /**
     * Model Attribute Labels
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email'    => 'Your Email Address',
            'name'     => 'Your Full Name',
            'password' => 'Your Password',
            'username' => 'Your Username'
        ];
    }

    /**
     * Saves the user's activation_key, and sends an email to the user with a link they can use to reset their password
     * @return boolean
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_user = new User;
        $this->_user->attributes = [
            'email'     => $this->email,
            'name'      => $this->name,
            'password'  => $this->password,
            'username'  => str_replace(' ', '', $this->username),
            'activated' => 0
        ];

        if ($this->_user->save()) {
            // Send an email to the user
            $sendgrid = new SendGrid(Yii::app()->params['includes']['sendgrid']['username'],
                Yii::app()->params['includes']['sendgrid']['password']);
            $email = new SendGrid\Email();

            $email->setFrom(Yii::app()->params['includes']['sendgrid']['from'])
                ->addTo($this->_user->email)
                ->setSubject("Activate Your Account")
                ->setText('Activate Your Account')
                ->setHtml(Yii::app()->controller->renderPartial('//email/activate', ['user' => $this->_user], true));

            // Send the email
            $sendgrid->send($email);

            // Return true if we get to this point
            return true;
        }

        return false;
    }
}
