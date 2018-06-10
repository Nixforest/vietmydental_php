<?php
/* @var $this ModulesController */
/* @var $model Modules */

//$this->breadcrumbs=array(
//	'Modules'=>array('index'),
//	$model->name,
//);
//
//$this->menu=array(
//	array('label'=>'List Modules', 'url'=>array('index')),
//	array('label'=>'Create Modules', 'url'=>array('create')),
//	array('label'=>'Update Modules', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Modules', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Modules', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<!--<h1>View Modules #<?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
	),
)); ?>
