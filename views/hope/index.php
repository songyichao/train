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
	<div class="table-responsive">
		<table class="table table-hover">
			<tr>
				<td colspan="6" class="text-center"><h3>目前服务客户</h3></td>
			</tr>
			<tr>
				<td>用户名</td>
				<td>出发站</td>
				<td>到达站</td>
				<td>出发时间</td>
				<td>车次</td>
				<td>席别</td>
			</tr>
			<?php
			if ($data) {
				foreach ($data as $item) {
					?>
					<tr>
						<td><?php echo $item['username']; ?></td>
						<td><?php echo $item['stat_station']; ?></td>
						<td><?php echo $item['end_station']; ?></td>
						<td><?php echo date('Y-m-d', $item['go_time']); ?></td>
						<td><?php echo $item['train_no']; ?></td>
						<td><?php echo $item['seat_type'] ;?></td>
					</tr>
					<?php
				}
			}
			?>
		
		</table>
	</div>

</div>
