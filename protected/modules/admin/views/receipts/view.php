<?php
/* @var $this ReceiptsController */
/* @var $model Receipts */

$this->breadcrumbs=array(
	'Receipts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Receipts', 'url'=>array('index')),
	array('label'=>'Create Receipts', 'url'=>array('create')),
	array('label'=>'Update Receipts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Receipts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Receipts', 'url'=>array('admin')),
);
?>

<h1>View Receipts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'detail_id',
		'process_date',
		'discount',
		'need_approve',
		'customer_confirm',
		'description',
		'created_date',
		'created_by',
		'status',
	),
)); ?>
