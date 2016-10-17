<?php

/**
 * Created by PhpStorm.
 * User: MIOJI
 * Date: 2016/10/17
 * Time: 上午11:38
 */
namespace app\helps;

use yii\httpclient\Client;
use Yii;

class Tools
{
	public static function curl($url, $data, $method = 'get')
	{
		$client = new Client();
		$response = $client->createRequest()
			->setMethod($method)
			->setOptions([
				'timeout' => 600,
				'userAgent' => method_exists(Yii::$app->request, 'getUserAgent') ? Yii::$app->request->getUserAgent() : null,
			])
			->setHeaders([])
			->setFormat('urlencoded')
			->setUrl($url)
			->setData($data)
			->send();
		if ($response->statusCode === '200') {
			return $response->content;
		} else {
			return false;
		}
	}
	
	public static function callToUser($phone, $data)
	{
		
	}
}