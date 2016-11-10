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
				<td colspan="7" class="text-center"><h3>监控通知查询结果通知详情</h3></td>
			</tr>
			
			<?php
			if ($data) {
				foreach ($data as $item) {
					?>
					<tr>
						<td>出发站</td>
						<td>到达站</td>
						<td>出发时间</td>
						<td>期望车次</td>
						<td>期望席别</td>
						<td>查到的车次</td>
						<td>查询时间</td>
					</tr>
					<tr>
						<td><?php echo $item['stat_station']; ?></td>
						<td><?php echo $item['end_station']; ?></td>
						<td><?php echo $item['go_time']; ?></td>
						<td><?php echo $item['train_no']; ?></td>
						<td><?php echo $item['seat_type']; ?></td>
						<td><?php
							if (empty($item['train'])) {
								echo "<span style='color: #942a25'>没有查到相应的票</span>";
							} else {
								echo "<span style='color: #00a000'>" . $item['train'] . "</span>";
							}
							?></td>
						<td><?php echo $item['ctime']; ?></td>
					</tr>
					<?php
				}
			}
			?>
		
		</table>
	</div>

</div>
