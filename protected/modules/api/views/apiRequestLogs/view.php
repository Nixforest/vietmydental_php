<?php
/* @var $this ApiRequestLogsController */
/* @var $model ApiRequestLogs */

$this->breadcrumbs=array(
	'Api Request Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ApiRequestLogs', 'url'=>array('index')),
	array('label'=>'Create ApiRequestLogs', 'url'=>array('create')),
	array('label'=>'Update ApiRequestLogs', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ApiRequestLogs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ApiRequestLogs', 'url'=>array('admin')),
);
?>

<h1>View ApiRequestLogs #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ip_address',
		'country',
		'user_id',
		'method',
		'content',
		'response',
		'created_date',
		'responsed_date',
	),
)); ?>
