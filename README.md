# train
基于yii2的12306查票应用
# 基本运行准备
### 1.下载代码
在web可访问目录下运行
```shell
git clone git@github.com:ITsyc/train.git
```
### 2.在train目录下更新组件
```shell
cd train
```
```shell
composer install
```
### 3.在项目目录的config文件夹下新建db.php添加如下配置项
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
