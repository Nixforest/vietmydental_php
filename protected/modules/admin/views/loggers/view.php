<?php
/* @var $this LoggersController */
/* @var $model Loggers */

$this->breadcrumbs=array(
	'Loggers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Loggers', 'url'=>array('index')),
	array('label'=>'Create Loggers', 'url'=>array('create')),
	array('label'=>'Update Loggers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Loggers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Loggers', 'url'=>array('admin')),
);
?>

<h1>View Loggers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ip_address',
		'country',
		'message',
		'created_date',
		'description',
		'level',
		'logtime',
		'category',
	),
)); ?>
