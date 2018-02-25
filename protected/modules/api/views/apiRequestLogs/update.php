<?php
/* @var $this ApiRequestLogsController */
/* @var $model ApiRequestLogs */

$this->breadcrumbs=array(
	'Api Request Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ApiRequestLogs', 'url'=>array('index')),
	array('label'=>'Create ApiRequestLogs', 'url'=>array('create')),
	array('label'=>'View ApiRequestLogs', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ApiRequestLogs', 'url'=>array('admin')),
);
?>

<h1>Update ApiRequestLogs <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>