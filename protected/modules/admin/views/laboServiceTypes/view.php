<?php
/* @var $this LaboServiceTypesController */
/* @var $model LaboServiceTypes */

//$this->breadcrumbs=array(
//	'Labo Service Types'=>array('index'),
//	$model->name,
//);
//
//$this->menu=array(
//	array('label'=>'List LaboServiceTypes', 'url'=>array('index')),
//	array('label'=>'Create LaboServiceTypes', 'url'=>array('create')),
//	array('label'=>'Update LaboServiceTypes', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete LaboServiceTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage LaboServiceTypes', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<!--<h1>View LaboServiceTypes #<?php // echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle.' '. $model->id;?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'status',
		'created_date',
		'created_by',
	),
)); ?>
