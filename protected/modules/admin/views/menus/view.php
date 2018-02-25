<?php
/* @var $this MenusController */
/* @var $model Menus */

//$this->breadcrumbs=array(
//	'Menuses'=>array('index'),
//	$model->name,
//);
//
//$this->menu=array(
//	array('label'=>'List Menus', 'url'=>array('index')),
//	array('label'=>'Create Menus', 'url'=>array('create')),
//	array('label'=>'Update Menus', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Menus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Menus', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<!--<h1>View Menus #<?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'link',
		'module_id',
		'controller_id',
		'action',
		'display_order',
		'show_in_menu',
		'place_holder_id',
		'application_id',
		'parent_id',
	),
)); ?>
