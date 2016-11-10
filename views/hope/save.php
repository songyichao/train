<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Hope';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
	<h1><?= Html::encode($this->title) ?></h1>
	
	<p>请输入你需要监控的车票信息</p>
	
	<?php $form = ActiveForm::begin([
		'id' => 'hope-save',
		'options' => ['class' => 'form-horizontal'],
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
			'labelOptions' => ['class' => 'col-lg-1 control-label'],
		],
	]); ?>
	
	<?= $form->field($model, 'stat_station')->textInput(['autofocus' => true]) ?>
	
	<?= $form->field($model, 'end_station')->textInput() ?>
	
	<?= $form->field($model, 'go_time')->textInput(['onClick' => 'WdatePicker()']) ?>
	
	<?= $form->field($model, 'train_no')->textInput() ?>
	
	<?= $form->field($model, 'seat_type')->textInput() ?>
	
	<div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
			<?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
		</div>
	</div>
	
	<?php ActiveForm::end(); ?>
	
	<div class="col-lg-offset-1" style="color:#999;">
		You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
		To modify the username/password, please check out the code <code>app\models\User::$users</code>.
	</div>
</div>
<script language="javascript" type="text/javascript" src="/My97DatePicker/WdatePicker.js"></script>
