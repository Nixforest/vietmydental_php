<?php
/* @var $this EmailTemplatesController */
/* @var $model EmailTemplates */

$this->breadcrumbs=array(
	'Email Templates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmailTemplates', 'url'=>array('index')),
	array('label'=>'Create EmailTemplates', 'url'=>array('create')),
	array('label'=>'Update EmailTemplates', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmailTemplates', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmailTemplates', 'url'=>array('admin')),
);
?>

<h1>View EmailTemplates #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'subject',
		'body',
		'param_description',
		'type',
	),
)); ?>
