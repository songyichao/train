<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 16/9/20
 * Time: 上午9:43
 */

namespace app\controllers;

use app\models\LoginForm;
use app\models\RegisterForm;
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
			return $this->goHome();
		}
		
		$model = new LoginForm();
		
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}
		
		return $this->render('login', ['model' => $model]);
	}
	
	public function actionRegister()
	{
		$model = new RegisterForm();
		$post = Yii::$app->request->post();
		if (!$post) {
			return $this->render('register', ['model' => $model]);
		}
		if ($model->load($post)) {
			echo 1;
			//			return $this->goBack();
		}
		var_dump($post);
	}
	
	public function actionSend()
	{
		$data = Yii::$app->request->post();
		$phone = $data['data'];
		$code = '';
		for ($i = 0; $i < 6; $i++) {
			$code .= rand(0, 9);
		}
		Yii::$app->session['code'] = $phone . $code;
		
		return Yii::$app->session['code'];
		return json_encode($data);
	}
}