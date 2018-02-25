<?php
/* @var $this ControllersActionsController */
/* @var $model ControllersActions */

//$this->breadcrumbs=array(
//	'Controllers Actions'=>array('index'),
//	$model->name,
//);
//
//$this->menu=array(
//	array('label'=>'List ControllersActions', 'url'=>array('index')),
//	array('label'=>'Create ControllersActions', 'url'=>array('create')),
//	array('label'=>'Update ControllersActions', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete ControllersActions', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage ControllersActions', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<!--<h1>View ControllersActions #<?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		//'controller_id',
                array(
                    'name' => 'controller',
                    'value' => $model->controller->description,
                ),
		'action',
		'name',
	),
)); ?>
