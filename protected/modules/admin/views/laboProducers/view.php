<?php
/* @var $this LaboProducersController */
/* @var $model LaboProducers */

$this->breadcrumbs=array(
	'Labo Producers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List LaboProducers', 'url'=>array('index')),
	array('label'=>'Create LaboProducers', 'url'=>array('create')),
	array('label'=>'Update LaboProducers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LaboProducers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LaboProducers', 'url'=>array('admin')),
);
?>

<h1>View LaboProducers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'address',
		'phone',
		'admin_id',
		'status',
		'created_date',
		'created_by',
	),
)); ?>
