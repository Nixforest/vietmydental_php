<?php
/* @var $this RolesController */
/* @var $model Roles */

//$this->breadcrumbs=array(
//	'Roles'=>array('index'),
//	$model->id,
//);
//
//$this->menu=array(
//	array('label'=>'List Roles', 'url'=>array('index')),
//	array('label'=>'Create Roles', 'url'=>array('create')),
//	array('label'=>'Update Roles', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Roles', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Roles', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<!--<h1>View Roles #<?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'role_name',
		'role_short_name',
		array(
                   'name'=>'application',
                   'value'=>$model->application->name,
                ),
		array(
                   'name'=>'status',
                   'type'=>'Status',
                ),
	),
)); ?>
