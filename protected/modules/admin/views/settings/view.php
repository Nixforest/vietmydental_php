<?php
/* @var $this SettingsController */
/* @var $model Settings */

//$this->breadcrumbs=array(
//	'Settings'=>array('index'),
//	$model->id,
//);
//
//$this->menu=array(
//	array('label'=>'List Settings', 'url'=>array('index')),
//	array('label'=>'Create Settings', 'url'=>array('create')),
//	array('label'=>'Update Settings', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Settings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Settings', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<!--<h1>View Settings #<?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'updated',
		'key',
		'value',
		'description',
	),
)); ?>
