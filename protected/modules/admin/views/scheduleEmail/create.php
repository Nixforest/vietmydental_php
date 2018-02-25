<?php
/* @var $this ScheduleEmailController */
/* @var $model ScheduleEmail */

$this->breadcrumbs=array(
	'Schedule Emails'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ScheduleEmail', 'url'=>array('index')),
	array('label'=>'Manage ScheduleEmail', 'url'=>array('admin')),
);
?>

<h1>Create ScheduleEmail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>