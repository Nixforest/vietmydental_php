<?php
/* @var $this LoginLogsController */
/* @var $model LoginLogs */

$this->breadcrumbs=array(
	'Login Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LoginLogs', 'url'=>array('index')),
	array('label'=>'Manage LoginLogs', 'url'=>array('admin')),
);
?>

<h1>Create LoginLogs</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>