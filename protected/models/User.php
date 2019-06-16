<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $new_email
 * @property string $password
 * @property string $name
 * @property integer $activated
 * @property integer $role_id
 * @property integer $created
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property Followers[] $followers
 * @property Followers[] $followers1
 * @property Shares[] $shares
 * @property Roles $role
 */
class User extends CMSActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['email, password, name, username', 'required'],
            ['activated, role_id, created, updated', 'numerical', 'integerOnly' => true],
            ['email, new_email, password, name, activation_key', 'length', 'max' => 255],
            ['email, password, name', 'required'],
            ['email', 'validateEmail'],
            ['username', 'validateUsername'],
            ['id, email, new_email, password, name, activated, role_id, created, updated', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'role'        => [self::BELONGS_TO, 'Role', 'role_id'],
            'posts'       => [self::HAS_MANY, 'Content', 'author_id'],
            'posts_count' => [self::STAT, 'Content', 'authior_id'],
            'metadata'    => [self::HAS_MANY, 'UserMetadata', 'user_id']
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'username'       => 'Username',
            'email'          => 'Email',
            'new_email'      => 'New Email',
            'password'       => 'Password',
            'name'           => 'Name',
            'activated'      => 'Activated',
            'activation_key' => 'Activation Key',
            'role_id'        => 'Role',
            'created'        => 'Created',
            'updated'        => 'Updated',
        ];
    }

    /**
     * Validates the user's email address
     * @param array $attributes array
     * @param array $params array
     * @return boolean
     */
    public function validateEmail($attributes = [], $params = [])
    {
        // Verify an email doesn't exists
        $user = User::model()->findByAttributes(['email' => $this->email]);
        if ($user != null && $user->id != $this->id) {
            $this->addError('email', 'A user with that email address already exists');
            return false;
        }

        return true;
    }

    /**
     * Validates the user's email address
     * @param array $attributes array
     * @param array $params array
     * @return boolean
     */
    public function validateUsername($attributes = [], $params = [])
    {
        // Verify an email doesn't exists
        $user = User::model()->findByAttributes(['username' => $this->username]);
        if ($user != null && $user->id != $this->id) {
            $this->addError('username', 'A user with that username already exists');
            return false;
        }

        return true;
    }

    /**
     * Before saving a user's password, password_hash it
     * @return parent::beforeSave()
     */
    public function beforeValidate()
    {
        if ($this->password == null) {
            if (!$this->isNewRecord) {
                $this->password = $this->_oldAttributes['password'];
            }
        } else {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 13]);
        }

        return parent::beforeSave();
    }

    /**
     * Sets the activation_key as appropriate for new users, after validation has passed
     * @see CController::beforeSave()
     */
    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->generateActivationKey();
            $this->role_id = 1;
        }

        return parent::beforeSave();
    }

    /**
     * Generate a random string, using a cryptographically secure
     * pseudorandom number generator (random_int)
     *
     * For PHP 7, random_int is a PHP core function
     * For PHP 5.x, depends on https://github.com/paragonie/random_compat
     *
     * @param int $length How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     * @return string
     * @throws Exception
     */
    public function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces [] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    /**
     * Sets the activation Key
     * @return string
     * @throws Exception
     */
    public function generateActivationKey()
    {
        $this->activation_key = preg_replace('/[^a-zA-Z0-9\']/', '_',
            $this->random_str(16));
        return $this->activation_key;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('new_email', $this->new_email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('activated', $this->activated);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('created', $this->created);
        $criteria->compare('updated', $this->updated);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
