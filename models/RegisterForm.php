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
			[['password', 'cf_password'], 'string', 'max' => 18],
			[['password', 'cf_password'], 'string', 'min' => 6],
			['username', 'validateUsername'],
			['cf_password', 'validatePassword'],
			['vcode', 'validateVcode'],
		];
	}
	
	public function validatePassword($attribute, $params)
	{
		if (!($this->password === $this->cf_password)) {
			$this->addError($attribute, '两次密码不一致');
		}
	}
	
	public function validateVcode($attribute, $params)
	{
		if (!($this->phone.$this->vcode === Yii::$app->session['code'])) {
			$this->addError($attribute, '验证码错误');
		}
	}
	public function validateUsername($attribute, $params)
	{
		if ((new User())->getUsername($this->username)) {
			$this->addError($attribute, '用户已存在');
		}
	}
	
	public function register()
	{
		$model = new UserInfo();
		$model->username = $this->username;
		$model->phone = $this->phone;
		$model->password = md5($this->password);
		$model->save(Yii::$app->db);
	}
}