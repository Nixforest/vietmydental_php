<?php
/* @var $this ApiRequestLogsController */
/* @var $model ApiRequestLogs */

$this->breadcrumbs=array(
	'Api Request Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ApiRequestLogs', 'url'=>array('index')),
	array('label'=>'Manage ApiRequestLogs', 'url'=>array('admin')),
);
?>

<h1>Create ApiRequestLogs</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>