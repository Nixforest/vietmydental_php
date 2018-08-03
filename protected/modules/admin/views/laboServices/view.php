<?php
/* @var $this LaboServicesController */
/* @var $model LaboServices */

$this->breadcrumbs=array(
	'Labo Services'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LaboServices', 'url'=>array('index')),
	array('label'=>'Create LaboServices', 'url'=>array('create')),
	array('label'=>'Update LaboServices', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LaboServices', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LaboServices', 'url'=>array('admin')),
);
?>

<h1>View LaboServices #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'price',
		'type_id',
		'producer_id',
		'time',
		'status',
		'created_date',
		'created_by',
	),
)); ?>
