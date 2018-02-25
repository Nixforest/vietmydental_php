<?php
/* @var $this LoginLogsController */
/* @var $model LoginLogs */

$this->breadcrumbs=array(
	'Login Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LoginLogs', 'url'=>array('index')),
	array('label'=>'Create LoginLogs', 'url'=>array('create')),
	array('label'=>'View LoginLogs', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LoginLogs', 'url'=>array('admin')),
);
?>

<h1>Update LoginLogs <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>