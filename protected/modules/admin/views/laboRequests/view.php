<?php
/* @var $this LaboRequestsController */
/* @var $model LaboRequests */

$this->breadcrumbs=array(
	'Labo Requests'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LaboRequests', 'url'=>array('index')),
	array('label'=>'Create LaboRequests', 'url'=>array('create')),
	array('label'=>'Update LaboRequests', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LaboRequests', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LaboRequests', 'url'=>array('admin')),
);
?>

<h1>View LaboRequests #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'treatment_detail_id',
		'service_id',
		'date_request',
		'date_receive',
		'date_test',
		'tooth_color',
		'teeths',
		'description',
		'price',
		'total',
		'status',
		'created_date',
		'created_by',
	),
)); ?>
