<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2016/10/26
 * Time: 下午12:25
 */

namespace app\models;

use Yii;
use yii\filters\VerbFilter;
use yii\base\Model;

class RegisterForm extends Model
{
	public $username;
	public $password;
	public $cf_password;
	public $phone;
	public $vcode;
	
	public function rules()
	{
		return [
			// username and password are both required
			[['username', 'password', 'cf_password', 'phone'], 'required'],
			// password is validated by validatePassword()
			['cf_password', 'validatePassword'],
		];
	}
	
	public function validatePassword($attribute, $params)
	{
		var_dump($this);
		if (!($this->password === $this->cf_password)) {
			$this->addError($attribute, '两次密码不一致');
		}
	}
}