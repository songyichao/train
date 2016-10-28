<?php

namespace app\models;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'user';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['username', 'phone', 'password'], 'required'],
			[['phone'], 'string', 'max' => 11],
			[['username'], 'string', 'max' => 20],
			[['password'], 'string', 'max' => 32],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'username' => 'Username',
			'phone' => 'Phone',
			'password' => 'Password',
		];
	}
	
	public function getUsername($username)
	{
		$res = (new Query())
			->select('id')
			->from(self::tableName())
			->where(['username' => $username])
			->scalar();
		return $res;
	}

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
	    $temp = parent::find()->where(['id' => $id])->one();
	    return isset($temp) ? new static($temp) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username, $password)
    {
	    $res = User::find()->where(['username' => $username, 'password' => $password])->one();
	    if ($res) {
		    return $res;
	    }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
