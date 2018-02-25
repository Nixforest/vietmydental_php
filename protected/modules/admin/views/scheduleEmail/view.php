<?php
/* @var $this ScheduleEmailController */
/* @var $model ScheduleEmail */

$this->breadcrumbs=array(
	'Schedule Emails'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ScheduleEmail', 'url'=>array('index')),
	array('label'=>'Create ScheduleEmail', 'url'=>array('create')),
	array('label'=>'Update ScheduleEmail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ScheduleEmail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ScheduleEmail', 'url'=>array('admin')),
);
?>

<h1>View ScheduleEmail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type',
		'template_id',
		'obj_id',
		'user_id',
		'email',
		'time_send',
		'created_date',
		'subject',
		'body',
		'json',
		'status',
	),
)); ?>
