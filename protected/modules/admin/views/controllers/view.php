<?php
/* @var $this ControllersController */
/* @var $model Controllers */

//$this->breadcrumbs=array(
//	'Controllers'=>array('index'),
//	$model->name,
//);
//
//$this->menu=array(
//	array('label'=>'List Controllers', 'url'=>array('index')),
//	array('label'=>'Create Controllers', 'url'=>array('create')),
//	array('label'=>'Update Controllers', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Controllers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Controllers', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<!--<h1>View Controllers #<?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
//		'module_id',
                array(
                    'name' => 'module_id',
                    'value' => $model->rModule->name,
                ),
		'description',
	),
)); ?>
