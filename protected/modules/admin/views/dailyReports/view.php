<?php
/* @var $this DailyReportsController */
/* @var $model DailyReports */

//$this->breadcrumbs=array(
//	'Daily Reports'=>array('index'),
//	$model->id,
//);
//
//$this->menu=array(
//	array('label'=>'List DailyReports', 'url'=>array('index')),
//	array('label'=>'Create DailyReports', 'url'=>array('create')),
//	array('label'=>'Update DailyReports', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete DailyReports', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage DailyReports', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle.' '. $model->id;?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'receipt_customer_total',
		'receipt_total_total',
		'receipt_discount_total',
		'receipt_final_total',
		'receipt_debit_total',
		'new_customer_total',
		'new_total_total',
		'new_discount_total',
		'new_final_total',
		'new_debit_total',
		'approve_id',
		'status',
		'created_by',
		'created_date',
	),
)); ?>
