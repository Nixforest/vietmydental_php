<?php
/* @var $this LoginLogsController */
/* @var $model LoginLogs */

$this->breadcrumbs=array(
	'Login Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LoginLogs', 'url'=>array('index')),
	array('label'=>'Create LoginLogs', 'url'=>array('create')),
	array('label'=>'Update LoginLogs', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LoginLogs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LoginLogs', 'url'=>array('admin')),
);
?>

<h1>View LoginLogs #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'role_id',
		'ip_address',
		'country',
		'description',
		'type',
		'created_date',
	),
)); ?>
