# train
基于yii2的12306查票应用
# 基本运行准备
### 1.环境监测
这个项目需要PHP7+的环境
### 2.下载代码
在web可访问目录下运行
```shell
git clone git@github.com:ITsyc/train.git
```
### 3.在train目录下更新组件
```shell
cd train
```
```shell
composer install
```
### 4.在项目目录的config文件夹下新建db.php添加如下配置项
```php
<?php

return [
	'class' => 'yii\db\Connection',
	'dsn' => 'mysql:host=host;dbname=name', //host 你的数据库连接， name 你的数据库名，
	'username' => 'username',  //账户
	'password' => 'password',  //密码
	'charset' => 'utf8',
];

```
### 5.执行sql文件
将项目根目录下的train.sql在自己的数据库中执行。生成数据表
### 6.修改config文件夹下的params.php
主要的修改是阿里大鱼的配置项，
```php
	'ali_dayu' =>[
		'm_appkey' => '23***7591', //你自己的阿里大鱼key
		'm_secretKey' => '072d43cc9***a7756d3fb182e03267b1', //你自己的阿里大鱼key
		'm_sign_name' => '有票了',
		'm_template_code' => 'SMS_229***0191',
		't_show_num' => '0514820***721',
		't_template_code' => 'TTS_160***181',
	],
```
到此，这项目就可以跑通了
# 运行commands中的文件
### 1.生成站点列表
```shell
php70 yii train/station
```
这个命令会将请求到的城市添加到相应的数据表中
### 2.执行定时任务
```shell
crontab -e
```
在其中添加

00 06 * * * cd /search/service/nginx/html/train && php70 yii train/index > /search/service/nginx/html/train/runtime/train/`date +"\%Y\%m\%d"`

**这里的`php70`是我的PHP版本，届时需要换成自己本地的`PHP版本`**
这个项目就可运行起来了，但是由于调用接口所产生的问题会导致某些时候不能获得想要的数据，所以可不可通就只能听天由命了