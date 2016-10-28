<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2016/10/27
 * Time: 下午7:20
 */

namespace app\controllers;

use app\models\LoginForm;
use app\models\UserHelp;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class HelpController extends Controller
{
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
	 * 展示表单
	 * @return string|\yii\web\Response
	 */
	public function actionIndex()
	{
		$model = new UserHelp();
		return $this->render('index', ['model' => $model]);
	}
	
	public function actionSave()
	{
		$data = Yii::$app->request->post();
		echo '<pre>';
		var_dump($data);
	}
}