<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2016/10/27
 * Time: 下午7:20
 */

namespace app\controllers;

use app\models\Log;
use app\models\LoginForm;
use app\models\StationCode;
use app\models\UserHope;
use Ladybug\Dumper;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class HopeController extends Controller
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
						'actions' => ['logout', 'save'],
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
		$data = (new UserHope())->showHope();
		$station = (new StationCode())->getAllCode();
		$seat_type = array_flip(Yii::$app->params['seat_type']);
		if ($data) {
			foreach ($data as $k => $item) {
				$data[$k]['stat_station'] = $station[$item['stat_station']];
				$data[$k]['end_station'] = $station[$item['end_station']];
				$data[$k]['seat_type'] = !empty($item['seat_type']) ? $seat_type[$item['seat_type']] : null;
			}
		}
		
		return $this->render('index', ['data' => $data]);
	}
	
	/**
	 * 展示表单
	 * @return string|\yii\web\Response
	 */
	public function actionSave()
	{
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$model = new UserHope();
		$data = Yii::$app->request->post();
		if (!$data) {
			return $this->render('save', ['model' => $model]);
		}
		if ($model->load($data) && $model->validate() && $model->saveHope($data['UserHope'])) {
			return $this->redirect('index');
		}
		return $this->render('save', ['model' => $model]);
	}
	
	public function actionLog()
	{
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$uid = Yii::$app->getUser()->id;
		$hope_arr = (new UserHope())->getHope($uid);
		$hid = ArrayHelper::getColumn($hope_arr, 'id');
		$station = (new StationCode())->getAllCode();
		$hope_res = (new Log())->getLog($hid);
		$data = [];
		if (!empty($hope_arr)) {
			foreach ($hope_res as $hope_re) {
				foreach ($hope_arr as $item) {
					if ($item['id'] === $hope_re['hid']) {
						$stat_station = $station[$item['stat_station']];
						$end_station = $station[$item['end_station']];
						$seat_type = empty($item['seat_type']) ? null : Yii::$app->params['seat_type'][$item['seat_type']];
						$go_time = date('Y-m-d', $item['go_time']);
						$train_no = empty($item['train_no']) ? '无' : $item['train_no'];
					}
				}
				
				$train_str = '';
				if (!empty($hope_re['train_no'])) {
					$train = json_decode($hope_re['train_no']);
					$train_str = substr(implode(',', $train), 0, 20) . '...';
				}
				
				$data[] = [
					'ctime' => date('Y-m-d h:i:s', $hope_re['ctime']),
					'stat_station' => $stat_station,
					'end_station' => $end_station,
					'seat_type' => $seat_type ?? '无',
					'go_time' => $go_time,
					'train_no' => $train_no,
					'train' => $train_str
				];
			}
			ArrayHelper::multisort($data, 'ctime', SORT_DESC);
		}
		return $this->render('log', ['data' => $data]);
	}
}