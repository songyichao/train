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
use yii\taobao\top\request\AlibabaAliqinFcSmsNumSendRequest;
use yii\taobao\top\request\AlibabaAliqinFcTtsNumSinglecallRequest;
use yii\taobao\top\TopClient;
use yii\taobao\Autoloader;
use yii\taobao\TopSdk;

class Tools
{
    protected static $ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36';

    public static function curl($url, $data, $method = 'get')
    {
        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod($method)
            ->setOptions([
                'timeout'   => 600,
                'userAgent' => method_exists(Yii::$app->request, 'getUserAgent') ? Yii::$app->request->getUserAgent() : self::$ua,
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

    public static function sendCode($phone, $code)
    {
        TopSdk::set();
        $taobao       = new Autoloader();
        $c            = new TopClient();
        $c->appkey    = Yii::$app->params['ali_dayu']['m_appkey'];
        $c->secretKey = Yii::$app->params['ali_dayu']['m_secretKey'];
        $req          = new AlibabaAliqinFcSmsNumSendRequest();
        $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName(Yii::$app->params['ali_dayu']['m_sign_name']);
        $req->setSmsParam("{\"code\":\"$code\"}");
        $req->setRecNum($phone);
        $req->setSmsTemplateCode(Yii::$app->params['ali_dayu']['m_template_code']);
        $resp = json_decode(json_encode($c->execute($req)), true);
        if (isset($resp['result']['err_code']) && $resp['result']['err_code'] === '0') {
            return true;
        }

        return false;
    }

    public static function callToUser($phone)
    {
        TopSdk::set();
        $taobao       = new Autoloader();
        $c            = new TopClient();
        $c->appkey    = Yii::$app->params['ali_dayu']['m_appkey'];
        $c->secretKey = Yii::$app->params['ali_dayu']['m_secretKey'];
        $req          = new AlibabaAliqinFcTtsNumSinglecallRequest();
        $req->setTtsParam('');
        $req->setCalledNum($phone);
        $req->setCalledShowNum(Yii::$app->params['ali_dayu']['t_show_num']);
        $req->setTtsCode(Yii::$app->params['ali_dayu']['t_template_code']);
        $resp = json_decode(json_encode($c->execute($req)), true);
        if (isset($resp['result']['err_code']) && $resp['result']['err_code'] === '0') {
            return true;
        }

        return false;
    }

    public static function code()
    {
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= rand(0, 9);
        }

        return $code;
    }
}