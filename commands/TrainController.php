<?php
/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2016/10/17
 * Time: 上午11:29
 */

namespace app\commands;

use app\models\Log;
use app\models\StationCode;
use app\models\UserHelp;
use yii\console\Controller;
use app\helps\Tools;

class TrainController extends Controller
{
	public function actionIndex()
	{
		$user_log = $user_id = [];
		$url = 'https://kyfw.12306.cn/otn/leftTicket/queryC';
		$user_help = (new UserHelp())->getUserHelp();
		if (!empty($user_help)) {
			foreach ($user_help as $item) {
				$data = [
					'leftTicketDTO.train_date' => date('Y-m-d', $item['go_time']),
					'leftTicketDTO.from_station' => $item['stat_station'],
					'leftTicketDTO.to_station' => $item['end_station'],
					'purpose_codes' => 'ADULT',
				];
				$response = Tools::curl($url, $data);
				if ($response !== false) {
					$res = json_decode($response, true);
					$can_buy = [];
					foreach ($res as $re) {
						if (!empty($item['train_no']) && $re['queryLeftNewDTO']['station_train_code'] === $item['train_no']
							&& $re['queryLeftNewDTO']['canWebBuy'] === 'Y'
						) {
							if (!empty($item['seat_type']) &&
								($re['queryLeftNewDTO'][$item['seat_type']] !== '无' || $re['queryLeftNewDTO'][$item['seat_type']] !== '--')
							) {
								$can_buy[] = $re['queryLeftNewDTO']['station_train_code'];
							} else {
								$can_buy[] = $re['queryLeftNewDTO']['station_train_code'];
							}
						}
						if (!empty($item['seat_type']) &&
							($re['queryLeftNewDTO'][$item['seat_type']] !== '无' || $re['queryLeftNewDTO'][$item['seat_type']] !== '--')
						) {
							$can_buy[] = $re['queryLeftNewDTO']['station_train_code'];
						}
						if (empty($item['seat_type']) && empty($item['seat_type'])) {
							if ($re['queryLeftNewDTO']['canWebBuy'] === 'Y') {
								$can_buy[] = $re['queryLeftNewDTO']['station_train_code'];
							}
						}
					}
					if (!empty($can_buy)) {
						Tools::callToUser($item['phone'], $can_buy);
						$user_id[] = $item['uid'];
						$user_log[] = [
							'uid' => $item['uid'],
							'train_no' => json_encode($can_buy),
							'status' => empty($can_buy) ? 0 : 1,
							'ctime' => time(),
						];
						
					}
				}
			}
			if (!empty($user_id)) {
				(new UserHelp())->changeStatus($user_id);
				(new Log())->saveLog($user_log);
			}
		}
	}
	
	public function actionStation()
	{
		$response = Tools::curl('https://kyfw.12306.cn/otn/resources/js/framework/station_name.js', ['station_version' => '1.8970']);
		if ($response === false) {
			saveStation();
		} else {
			$str = str_replace('var station_names =', '', $response);
			$str = str_replace("'", '', $str);
			$str = trim($str);
			$arr = explode('@', $str);
			unset($arr[0]);
			$station = [];
			foreach ($arr as $v) {
				$stat = explode('|', $v);
				$station[] = [
					'name' => $stat[1],
					'code' => $stat[2],
				];
			}
			$res = (new StationCode())->saveCode($station);
			return $res;
		}
	}
}