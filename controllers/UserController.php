<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 16/9/20
 * Time: 上午9:43
 */

namespace app\controllers;

use app\helps\Tools;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\UserInfo;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class UserController extends Controller
{
	public $enableCsrfValidation = false;
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}
	
	/**
	 * 登录功能
	 * @return string|\yii\web\Response
	 */
	public function actionIndex()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->redirect('/hope');
		}
		
		$model = new LoginForm();
		
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->redirect('/hope');
		}
		
		return $this->render('login', ['model' => $model]);
	}
	
	/**
	 * 实现注册功能
	 * @return string|\yii\web\Response
	 */
	public function actionRegister()
	{
		$model = new RegisterForm();
		$post = Yii::$app->request->post();
		if (!$post) {
			return $this->render('register', ['model' => $model]);
		}
		if ($model->load($post) && $model->validate()) {
			$model->register();
			return $this->redirect('index');
		}
		return $this->render('register', ['model' => $model]);
	}
	
	/**
	 * 发送短信验证码
	 * @return mixed|string|void
	 */
	public function actionSend()
	{
		$data = Yii::$app->request->post();
		$phone = $data['data'];
		$code = Tools::code();
		Yii::$app->session['code'] = $phone . $code;
		$res = Tools::sendCode($phone, $code);
		return json_encode($code);
	}
	
	public function actionLogout()
	{
		Yii::$app->user->logout();
		
		return $this->goHome();
	}
}